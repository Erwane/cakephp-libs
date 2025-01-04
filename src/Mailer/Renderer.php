<?php
declare(strict_types=1);

/**
 * CakePHP Erwane libs
 * Copyright (c) Erwane BRETON
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Erwane BRETON
 * @see         https://github.com/Erwane/cakephp-libs
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Ecl\Mailer;

use Cake\I18n\DateTime;
use Cake\Mailer\Renderer as CakeMailerRenderer;
use Cake\View\StringTemplate;
use Cake\View\StringTemplateTrait;

/**
 * Class Renderer
 */
class Renderer extends CakeMailerRenderer
{
    use StringTemplateTrait;

    protected array $_defaultVars = [
        'layout_bg' => '#f8f9fa',
        'head_bg' => '#68503d',
        'head_text' => '#ffffff',
        'body_bg' => '#ffffff',
        'body_text' => '#333333',
        'footer_bg' => '#efefef',
        'footer_text' => '#36392e',
        'btn_bg' => '#68503d',
        'btn_text' => '#ffffff',
        'link_color' => '#68503d',
        'email_subject' => null,
        'email_date' => null,
    ];

    protected array $_allowedVars = [];

    /**
     * Set allowed vars
     *
     * @param array $vars allowed vars keys
     * @param bool $merge Merge allowed vars
     * @return self
     */
    public function setAllowedVars(array $vars, bool $merge = true): self
    {
        $vars = array_map('strtoupper', $vars);
        if ($merge) {
            $this->_allowedVars = array_merge($this->_allowedVars, $vars);
        } else {
            $this->_allowedVars = $vars;
        }

        return $this;
    }

    /**
     * Render original content and
     * search/replace allowed vars in it
     *
     * @param string $content Message content
     * @param array $types Email types
     * @return array
     */
    public function render(string $content, array $types = []): array
    {
        // Render email from content or template for each types
        $templates = parent::render($content, $types);

        // Populate vars to replace
        $vars = $this->getVars();

        $templater = new StringTemplate($templates);

        $rendered = [];
        foreach ($templates as $type => $template) {
            $rendered[$type] = $templater->format($type, $vars);
        }

        return $rendered;
    }

    /**
     * Get array with allowed vars in key and
     * value to insert in value
     *
     * @return array
     */
    public function getVars(): array
    {
        $vars = [];

        // allow default vars keys
        $defaultVarKeys = array_map('strtoupper', array_keys($this->_defaultVars));
        $this->_allowedVars = array_merge($this->_allowedVars, $defaultVarKeys);

        // default population
        foreach ($this->viewBuilder()->getVars() as $prefix => $var) {
            $key = strtoupper($prefix);

            if (is_object($var)) {
                if (method_exists($var, 'toArray')) {
                    $ary = $var->toArray();
                } else {
                    $ary = $this->_getValue($var);
                }
            } else {
                $ary = $var;
            }

            if (is_array($ary)) {
                foreach ($ary as $name => $value) {
                    $key = strtoupper($prefix) . '_' . strtoupper($name);
                    if (in_array($key, $this->_allowedVars)) {
                        $vars[$key] = $this->_getValue($value);
                    }
                }
            } elseif (in_array($key, $this->_allowedVars)) {
                $vars[$key] = h($ary);
            }
        }

        return $vars;
    }

    /**
     * Get printable value of string object or I18nDateTimeInterface.
     *
     * @param mixed $value Object with __toString, I18nDateTimeInterface or anything else
     * @return mixed Printable value or null
     */
    protected function _getValue(mixed $value): mixed
    {
        if ($value instanceof DateTime) {
            $value = $value->i18nFormat();
        } elseif (is_object($value)) {
            if (method_exists($value, '__toString')) {
                $value = (string)$value;
            } else {
                return null;
            }
        } elseif (is_array($value)) {
            return null;
        }

        return h($value);
    }
}
