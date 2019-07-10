<?php
namespace Ecl\Mailer;

use Cake\I18n\I18n;
use Cake\Mailer\Email as CakeEmail;
use Cake\View\StringTemplateTrait;
use InvalidArgumentException;
use HTMLPurifier;
use HTMLPurifier_Config;

class Email extends CakeEmail
{
    use StringTemplateTrait;

    protected $_defaultVars = [
        'email_subject' => null,
        'email_date' => null,
        'validation_button' => null,
    ];

    protected $_cleanSubject;

    protected $_allowedVars = [];

    protected $_vars = [];

    protected $_rawContent = ['html' => null, 'text' => null];

    /**
     * {@inheritDoc}
     */
    public function __construct($config = null)
    {
        parent::__construct($config);

        $this->set($this->_defaultVars);
    }

    /**
     * print html element to page and exit
     * @return void
     */
    public function debug()
    {
        $rendered = $this->_renderTemplates([]);
        echo $rendered['html'];
        exit;
    }

    /**
     * set allowed vars in this template
     * @param array $vars allowed vars keys
     * @return self
     */
    public function setAllowedVars(array $vars)
    {
        $vars = array_map('strtoupper', $vars);

        $this->_allowedVars = array_merge($this->_allowedVars, $vars);

        return $this;
    }

    /**
     * set allowed var in this template
     * @param string $name allowed var name
     * @return self
     */
    public function setAllowedVar(string $name)
    {
        $name = strtoupper($name);

        if (empty($name)) {
            throw new InvalidArgumentException('var name is empty');
        }

        if (array_search($name, $this->_allowedVars) === false) {
            array_push($this->_allowedVars, $name);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setSubject($subject)
    {
        $this->_cleanSubject = (string)$subject;

        return parent::setSubject($subject);
    }

    /**
     * {@inheritDoc}
     */
    protected function _renderTemplates($content)
    {
        $types = $this->_getTypes();
        $rendered = [];
        $template = $this->viewBuilder()->getTemplate();

        if ($this->hasCustomContent()) {
            $template = null;
        }

        if (empty($template)) {
            foreach ($types as $type) {
                if (!empty($this->_rawContent[$type])) {
                    $rendered[$type] = $this->_encodeString($this->_rawContent[$type], $this->charset);
                } else {
                    $rendered[$type] = $this->_encodeString($content, $this->charset);
                }
            }

            return $this->format($this->withText($rendered));
        }

        $View = $this->createView();

        list($templatePlugin) = pluginSplit($View->getTemplate());
        list($layoutPlugin) = pluginSplit($View->getLayout());
        if ($templatePlugin) {
            $View->setPlugin($templatePlugin);
        } elseif ($layoutPlugin) {
            $View->setPlugin($layoutPlugin);
        }

        if ($View->get('content') === null) {
            $View->set('content', $content);
        }

        foreach ($types as $type) {
            $View->hasRendered = false;
            $View->setTemplatePath('Email' . DIRECTORY_SEPARATOR . $type);
            $View->setLayoutPath('Email' . DIRECTORY_SEPARATOR . $type);

            $render = $View->render();
            $render = str_replace(["\r\n", "\r"], "\n", $render);
            $rendered[$type] = $this->_encodeString($render, $this->charset);
        }

        foreach ($rendered as $type => $content) {
            $rendered[$type] = $this->_wrap($content);
            $rendered[$type] = implode("\n", $rendered[$type]);
            $rendered[$type] = rtrim($rendered[$type], "\n");
        }

        return $this->format($rendered);
    }

    /**
     * check if content is set from mailer instead of template
     * @return bool
     */
    public function hasCustomContent()
    {
        return !empty($this->_rawContent['html']) || !empty($this->_rawContent['text']);
    }

    /**
     * set html body of email instead of using template
     * @param string $content html email content
     * @return self
     */
    public function setHtmlBody($content)
    {
        $this->_rawContent['html'] = $content;
        $this->setEmailFormat('both');

        return $this;
    }

    /**
     * set text body of email instead of using template
     * @param string $content text email content
     * @return self
     */
    public function setTextBody($content)
    {
        $this->_rawContent['text'] = $content;
        $this->setEmailFormat('text');

        return $this;
    }

    /**
     * create a simple text part with html
     * @param  array $rendered rendered message
     * @return array
     */
    public function withText($rendered)
    {
        // text already exists
        if (!empty($rendered['text'])) {
            return $rendered;
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray([
            'Cache.DefinitionImpl' => null,
            'HTML.AllowedElements' => [],
        ]);

        $purifier = new HTMLPurifier($config);

        $text = str_replace('&nbsp;', ' ', $rendered['html']);
        $text = $purifier->purify($text);

        $text = trim($text);

        $text = preg_replace('/^ +/m', '', $text);
        $text = preg_replace('/ +/m', ' ', $text);
        $text = preg_replace('/\n{2,}/m', "\n\n", $text);

        $rendered['text'] = trim($text);

        return $rendered;
    }

    public function format(array $rendered)
    {
        $this->setTemplates($rendered);

        $this->_populateVars();

        $formated = [];
        foreach (array_keys($rendered) as $type) {
            $formated[$type] = $this->formatTemplate($type, $this->_vars);
        }

        return $formated;
    }

    /**
     * populate $_vars array with var/value
     * can call a special method based on templateName
     * @return void
     */
    private function _populateVars()
    {
        $this->set('EMAIL_SUBJECT', $this->_cleanSubject);

        $vars = $this->getViewVars();

        // allow default vars keys
        $defaultVarKeys = array_map('strtoupper', array_keys($this->_defaultVars));
        $this->_allowedVars = array_merge($this->_allowedVars, $defaultVarKeys);

        // default population
        foreach ($vars as $prefix => $var) {
            $key = strtoupper($prefix);

            // skipped already setted vars
            if (isset($this->_vars[$key])) {
                continue;
            }

            if (is_object($var)) {
                if (method_exists($var, 'toArray')) {
                    $ary = $var->toArray();
                }

                if (method_exists($var, 'getAliases')) {
                    foreach ($var->getAliases() as $a => $k) {
                        $ary[$a] = $var->{$a};
                    }
                }
            } else {
                $ary = $var;
            }

            if (is_array($ary)) {
                foreach ($ary as $name => $value) {
                    $key = strtoupper($prefix) . '_' . strtoupper($name);
                    if (array_search($key, $this->_allowedVars) !== false) {
                        $this->_vars[$key] = $this->_varValue($value);
                    }
                }
            } elseif (array_search($key, $this->_allowedVars) !== false) {
                $this->_vars[$key] = $ary;
            }
        }
    }

    /**
     * get value. Specially made for date object, but usable for other things
     * @param mixed $value can be CakeTimeObject or int or string ...
     * @return mixed formated value
     */
    private function _varValue($value)
    {
        if ($value instanceof \Cake\Chronos\ChronosInterface) {
            // Cake date/time timezone
            //$value->setTimezone($this->_timezone);

            return $value->i18nFormat();
        } elseif ($this->_isDateTime($value)) {
            // Date or time
            return $this->dateTime($value);
        } elseif (is_array($value)) {
            // array
            return null;
        }

        return $value;
    }

    /**
     * check if string is date/time
     * @param string $str to check
     * @return bool
     */
    private function _isDateTime($str)
    {
        return is_string($str) && preg_match('/\d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})?/', $str);
    }
}
