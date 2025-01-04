<?php
declare(strict_types=1);

/**
 * CakePHP Erwane libs
 * Copyright (c) Erwane BRETON
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Erwane BRETON
 * @see         https://github.com/Erwane/cakephp-libs
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Ecl\Validation;

/**
 * Class Password
 */
class Password
{
    private static array $_default = [
        'size' => 10,
        'minimalLowercase' => 2,
        'minimalUppercase' => 2,
        'minimalDigit' => 2,
        'minimalSymbol' => 2,
        'lowers' => 'abcdefghijklmnopqrstuvwxyz',
        'uppers' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'digits' => '1234567890',
        'symbols' => '!*#+=:,-_?',
        'validate' => 'all',
    ];

    /**
     * Minimal lower
     *
     * @param string $input Input
     * @param int $min Minimal value
     * @return bool
     */
    public static function minimalLowercase(string $input, int $min): bool
    {
        return preg_match_all('/\p{Ll}/u', $input) >= $min;
    }

    /**
     * Minimal upper
     *
     * @param string $input Input
     * @param int $min Minimal value
     * @return bool
     */
    public static function minimalUppercase(string $input, int $min): bool
    {
        return preg_match_all('/\p{Lu}/u', $input) >= $min;
    }

    /**
     * Minimal digit
     *
     * @param string $input Input
     * @param int $min Minimal value
     * @return bool
     */
    public static function minimalDigit(string $input, int $min): bool
    {
        return preg_match_all('/[0-9]/', $input) >= $min;
    }

    /**
     * Minimal symbol
     *
     * @param string $input Input
     * @param int $min Minimal value
     * @return bool
     */
    public static function minimalSymbol(string $input, int $min): bool
    {
        // remove alpha and digits
        $input = preg_replace('/[\p{L}\p{N}]/u', '', $input);

        return strlen($input) >= $min;
    }

    /**
     * Get valid and context with default key
     *
     * @param string $defaultKey $_default key
     * @param array|string|null $valid valid list OR context
     * @param array|null $context Validation context
     * @return array
     */
    private static function _validAndContext(
        string $defaultKey,
        array|string|null $valid = null,
        ?array $context = null
    ): array {
        if (is_array($valid) && $context === null) {
            $context = $valid;
            $valid = null;
        }

        if ($valid === null || $valid === '') {
            $valid = static::$_default[$defaultKey];
        }

        return compact(['valid', 'context']);
    }

    /**
     * Only valid lowercase
     *
     * @param string $input Input
     * @param array|string|null $valid valid list OR context
     * @param array|null $context Validation context
     * @return bool
     */
    public static function validateLowers(string $input, array|string|null $valid = null, ?array $context = null): bool
    {
        extract(static::_validAndContext('lowers', $valid, $context));

        // remove not lower case
        $input = preg_replace('/\P{Ll}/u', '', $input);

        // remove valid
        $input = preg_replace('/[' . preg_quote($valid) . ']/', '', $input);

        return strlen($input) === 0;
    }

    /**
     * only valid uppercase
     *
     * @param string $input Input
     * @param array|string|null $valid valid list OR context
     * @param array|null $context Validation context
     * @return bool
     */
    public static function validateUppers(string $input, array|string|null $valid = null, ?array $context = null): bool
    {
        extract(static::_validAndContext('uppers', $valid, $context));

        // remove not upper case
        $input = preg_replace('/\P{Lu}/u', '', $input);

        // remove valid
        $input = preg_replace('/[' . preg_quote($valid) . ']/', '', $input);

        return strlen($input) === 0;
    }

    /**
     * only valid digits
     *
     * @param string $input Input
     * @param array|string|null $valid valid list OR context
     * @param array|null $context Validation context
     * @return bool
     */
    public static function validateDigits(string $input, array|string|null $valid = null, ?array $context = null): bool
    {
        extract(static::_validAndContext('digits', $valid, $context));

        // remove not digits
        $input = preg_replace('/\P{Nd}/u', '', $input);

        // remove valid
        $input = preg_replace('/[' . preg_quote($valid) . ']/', '', $input);

        return strlen($input) === 0;
    }

    /**
     * only valid symbols
     *
     * @param string $input Input
     * @param array|string|null $valid valid list OR context
     * @param array|null $context Validation context
     * @return bool
     */
    public static function validateSymbols(
        string $input,
        array|string|null $valid = null,
        ?array $context = null
    ): bool {
        extract(static::_validAndContext('symbols', $valid, $context));

        // remove alpha and digits
        $input = preg_replace('/[\p{L}\p{N}]/u', '', $input);

        // remove valid
        $input = preg_replace('/[' . preg_quote($valid) . ']/', '', $input);

        return strlen($input) === 0;
    }
}
