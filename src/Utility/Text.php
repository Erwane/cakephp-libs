<?php
namespace Ecl\Utility;

use Cake\Core\Configure;
use Cake\Utility\Text as CakeText;

class Text extends CakeText
{
    static public function countCapitals($string)
    {
        return strlen(preg_replace('/[^A-Z]/', '', $string));
    }

    static public function countLowercases($string)
    {
        return strlen(preg_replace('/[^a-z]/', '', $string));
    }

    static public function countDigits($string)
    {
        return strlen(preg_replace('/[^0-9]/', '', $string));
    }

    static public function urlsToLinks($text)
    {
        preg_match_all('`(http(s)?://([a-z0-9\._%&=/#\?-]+))`i', $text, $grep);
        if (!empty($grep[1])) {
            $patterns = array_map(function($v) {
                return '/' . preg_quote($v, '/') . '/';
            }, $grep[1]);

            $replaces = array_map(function($v) {
                return '<a href="' . $v . '">' . $v . '</a>';
            }, $grep[1]);

            return preg_replace($patterns, $replaces, $text);
        }

        return $text;
    }

    /**
    * Convert BR tags to nl
    *
    * @param string The string to convert
    * @return string The converted string
    */
    public static function br2nl($string)
    {
        return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    }

    /**
     * slugify an url title correctly
     * @param  string $title   text for url
     * @param  array  $params options
     *  - `stopWords`   if true, remove common short words
     *  - `cut`         if not empty, cut the slug for `cut` value words
     * @return string
     */
    public static function urlSlug($title, $params = []) {

        $params = array_merge(['stopWords' => true, 'cut' => 0], $params);
        extract($params);

        // minus
        $title = mb_convert_case($title, MB_CASE_LOWER, Configure::read('App.encoding'));
        $title = parent::slug($title, ' ');

        // recolle des mots
        $title = preg_replace('`(\d+)\s(eme|er)\s`', '$1$2 ', $title);

        if ($stopWords) {
            // nettoyage des lettres seules
            $search = array("`^[a-z]\s`", "`\s+[a-z]\s+`",);
            $replace = array('', ' ',);
            // remplace 2 fois
            $title = preg_replace($search, $replace, preg_replace($search, $replace, $title));

            // supprime les mots inutiles SI on a plus de 4 mots
            if ($cut > 0 && str_word_count($title) > $cut) {
                $bad = '(la|du|et|les?|des?|tes?|au|en|un|avec|dans|pour|sur|sous|par|ma|cet|of|to)';
                $search = ['/^' . $bad . '\s/', '/\s' . $bad . '\s/'];
                $replace = ['', ' '];
                $title = preg_replace($search, $replace, preg_replace($search, $replace, $title));
            }
        }

        // slugify
        $title = parent::slug($title, '-');

        if ($cut > 0) {
            // keep 4 words only
            $title = implode('-', array_slice(explode('-', $title), 0, $cut));
        }

        return $title;
    }
}
