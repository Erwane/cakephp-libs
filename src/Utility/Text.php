<?php
namespace Ecl\Utility;

class Text
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
}
