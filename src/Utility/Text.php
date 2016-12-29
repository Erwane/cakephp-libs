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
}
