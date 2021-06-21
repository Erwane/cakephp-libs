<?php
declare(strict_types=1);

namespace Ecl\Auth;

use Ecl\Utility\Text;

/**
 * Class Password
 *
 * @package Ecl\Auth
 */
class Password
{
    /**
     * hash a password with CRYPT_SHA512
     *
     * @param  string $password plai password
     * @return string encrypted password
     */
    public static function hash($password)
    {
        return crypt($password, '$6$' . self::_salt() . '$');
    }

    /**
     * generate a 16 chars salt
     *
     * @return string
     */
    protected static function _salt(): string
    {
        return substr(hash('sha256', uniqid()), mt_rand(0, 46), 16);
    }

    /**
     * Robust but easy to write password
     *
     * @return string
     */
    public static function easyPassword(): string
    {
        $chars = [
            0 => '23456789',
            'a' => 'abcdefghijkmnopqrstuvwxyz',
            'A' => 'ABCDEFGHJKLMNPQRSTUVWXYZ',
        ];

        $password = ['a' => '', 'A' => '', 0 => ''];
        for ($i = 1; $i <= 4; $i++) {
            $password['a'] .= $chars['a'][mt_rand(0, strlen($chars['a']) - 1)];
            $password['A'] .= $chars['A'][mt_rand(0, strlen($chars['A']) - 1)];
            $password[0] .= $chars[0][mt_rand(0, strlen($chars[0]) - 1)];
        }

        return $password['a'] . $password['A'] . $password[0];
    }

    /**
     * Generate simple password
     *
     * @param  int $length Password length
     * @return string
     */
    public static function simplePassword($length = 16): string
    {
        return self::password('simple', $length);
    }

    /**
     * Generate medium password
     *
     * @param  int $length Password length
     * @return string
     */
    public static function mediumPassword($length = 10): string
    {
        return self::passwordWithMinimals('medium', $length);
    }

    /**
     * Generate password
     *
     * @param  array $options Password options
     * @return string
     * @throws \Exception
     */
    public static function generate(array $options = []): string
    {
        $options += [
            'size' => 10,
            'minimalLower' => 2,
            'minimalUpper' => 2,
            'minimalDigit' => 2,
            'minimalSymbol' => 2,
            'lowers' => 'abcdefghijkmnopqrstuvwxyz',
            'uppers' => 'ABCDEFGHJKLMNPQRSTUVWXYZ',
            'digits' => '1234567890',
            'symbols' => '!*#+=:,-_?',
        ];

        $str = '';

        foreach (['lower', 'upper', 'digit', 'symbol'] as $key) {
            $minimal = $options['minimal' . ucfirst($key)];

            if (!$minimal) {
                continue;
            }

            $content = $options[$key . 's'];

            for ($i = 1; $i <= $minimal; $i++) {
                $str .= $content[random_int(0, strlen($content) - 1)];
            }
        }

        if (strlen($str) < $options['size']) {
            // complete with lower
            $lowers = $options['lowers'];
            for ($i = strlen($str); $i < $options['size']; $i++) {
                $str .= $lowers[random_int(0, strlen($lowers) - 1)];
            }
        }

        return str_shuffle($str);
    }

    /**
     * Generate password with minimals chars
     *
     * @param  string $type Password type
     * @param  int $length Length
     * @return string
     */
    public static function passwordWithMinimals($type = 'medium', $length = 10): string
    {
        $check = false;
        $pass = 0;
        $password = '';
        while (!$check) {
            $pass++;
            $password = self::password($type, $length);

            $check = Text::countLowercases($password) >= 2
                && Text::countCapitals($password) >= 2
                && Text::countDigits($password) >= 2;

            if ($pass >= 10) {
                $check = true;
            }
        }

        return $password;
    }

    /**
     * Generate password for type (simple, medium, high)
     *
     * @param  string $type Password type
     * @param  int $length Password length
     * @return string
     */
    public static function password($type = 'medium', $length = 10): string
    {
        $chars = [
            'min' => 'abcdefghijkmnopqrstuvwxyz',
            'maj' => 'ABCDEFGHJKLMNPQRSTUVWXYZ',
            'digit' => '23456789',
            'symbol' => '!$*()',
        ];

        if ($type == 'simple') {
            $string = $chars['min'] . $chars['maj'];
        } elseif ($type == 'medium') {
            $string = $chars['min'] . $chars['maj'] . $chars['digit'];
        } else {
            $string = $chars['min'] . $chars['maj'] . $chars['digit'] . $chars['symbol'];
        }

        $code = '';
        $codeLength = 0;
        while ($codeLength < $length) {
            $char = mt_rand(0, strlen($string) - 1);
            $code .= $string[$char];

            $codeLength++;
        }

        return $code;
    }
}
