<?php
namespace Ecl\Auth;

use Ecl\Utility\Text;

class Password
{
    /**
     * hash a password with CRYPT_SHA512
     * @param  string $password plai password
     * @return string encrypted password
     */
    public function hash($password)
    {
        return crypt($password, '$6$' . $this->_salt() . '$');
    }

    /**
     * generate a 16 chars salt
     * @return [type] [description]
     */
    private function _salt()
    {
        return substr(hash('sha256', uniqid()), mt_rand(0, 46), 16);
    }

    /**
     * robust but easy to write password
     */
    static public function easyPassword()
    {
        $chars = [
            0 => "23456789",
            'a' => "abcdefghijkmnopqrstuvwxyz",
            'A' => "ABCDEFGHJKLMNPQRSTUVWXYZ",
        ];

        $password = ['a' => '', 'A' => '', 0 => ''];
        for ($i = 1; $i <= 4;$i++) {
            $password['a'] .= $chars['a'][mt_rand(0,strlen($chars['a']) -1)];
            $password['A'] .= $chars['A'][mt_rand(0,strlen($chars['A']) -1)];
            $password[0] .= $chars[0][mt_rand(0,strlen($chars[0]) -1)];
        }

        return $password['a'] . $password['A'] . $password[0];
    }

    static public function simplePassword($length = 16)
    {
        return self::_password('simple', $length);
    }

    static public function mediumPassword($length = 10)
    {
        return self::_passwordWithMinimals('medium', $length);
    }

    static public function _passwordWithMinimals($type = 'medium', $length = 10)
    {
        $check = false;
        $pass = 0;
        while ( !$check ) {
            $pass++;
            $password = self::_password($type, $length);

            $check = Text::countLowercases($password) >= 2 && Text::countCapitals($password) >= 2 && Text::countDigits($password) >= 2;

            if ($pass >= 10)
                $check=true;
        }

        return $password;
    }

    static public function _password($type = 'medium', $length = 10)
    {
        $chars = [
            'min' => 'abcdefghijkmnopqrstuvwxyz',
            'maj' => 'ABCDEFGHJKLMNPQRSTUVWXYZ',
            'digit' => '23456789',
            'symbol' => '!$*()',
        ];

        if ($type == 'simple') {
            $string = $chars['min'] . $chars['maj'];
        } else if ($type == 'medium') {
            $string = $chars['min'] . $chars['maj'] . $chars['digit'];
        } else if ($type == 'high') {
            $string = $chars['min'] . $chars['maj'] . $chars['digit'] . $chars['symbol'];
        }

        $code = '';
        while (strlen($code) < $length) {
            $char = mt_rand(0, strlen($string) - 1);
            $code .= $string{$char};
        }
        return $code;
    }
}
