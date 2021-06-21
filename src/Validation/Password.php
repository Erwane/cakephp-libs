<?php
declare(strict_types=1);

namespace Ecl\Validation;

/**
 * Class Password
 *
 * @package Ecl\Validation
 */
class Password
{
    private static $_default = [
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
     * @param  string $input Input
     * @param  int $min Minimal value
     * @return bool
     */
    public static function minimalLowercase(string $input, int $min): bool
    {
        return preg_match_all('/\p{Ll}/u', $input) >= $min;
    }

    /**
     * Minimal upper
     *
     * @param  string $input Input
     * @param  int $min Minimal value
     * @return bool
     */
    public static function minimalUppercase(string $input, int $min): bool
    {
        return preg_match_all('/\p{Lu}/u', $input) >= $min;
    }

    /**
     * Minimal digit
     *
     * @param  string $input Input
     * @param  int $min Minimal value
     * @return bool
     */
    public static function minimalDigit(string $input, int $min): bool
    {
        return preg_match_all('/[0-9]/', $input) >= $min;
    }

    /**
     * Minimal symbol
     *
     * @param  string $input Input
     * @param  int $min Minimal value
     * @return bool
     */
    public static function minimalSymbol(string $input, int $min): bool
    {
        // remove alpha and digits
        $input = preg_replace('/[\p{L}\p{N}]/u', '', $input);

        return strlen($input) >= $min;
    }

    /**
     * Get valids and context with default key
     *
     * @param  string $defaultKey $_default key
     * @param  null|array|string $valids valid list OR context
     * @param  array|null $context Validation context
     * @return array
     */
    private static function _validsAndContext(string $defaultKey, $valids = null, ?array $context = null): array
    {
        if (is_array($valids) && $context === null) {
            $context = $valids;
            $valids = null;
        }

        if ($valids === null || $valids === '') {
            $valids = static::$_default[$defaultKey];
        }

        return compact(['valids', 'context']);
    }

    /**
     * Only valid lowercase
     *
     * @param  string $input Input
     * @param  null|array|string $valids valid list OR context
     * @param  array|null $context Validation context
     * @return bool
     */
    public static function validateLowers(string $input, $valids = null, ?array $context = null)
    {
        extract(static::_validsAndContext('lowers', $valids, $context));

        // remove not lower case
        $input = preg_replace('/\P{Ll}/u', '', $input);

        // remove valids
        $input = preg_replace('/[' . preg_quote($valids) . ']/', '', $input);

        return strlen($input) === 0;
    }

    /**
     * only valid uppercase
     *
     * @param  string $input Input
     * @param  null|array|string $valids valid list OR context
     * @param  array|null $context Validation context
     * @return bool
     */
    public static function validateUppers(string $input, $valids = null, ?array $context = null)
    {
        extract(static::_validsAndContext('uppers', $valids, $context));

        // remove not upper case
        $input = preg_replace('/\P{Lu}/u', '', $input);

        // remove valids
        $input = preg_replace('/[' . preg_quote($valids) . ']/', '', $input);

        return strlen($input) === 0;
    }

    /**
     * only valid digits
     *
     * @param  string $input Input
     * @param  null|array|string $valids valid list OR context
     * @param  array|null $context Validation context
     * @return bool
     */
    public static function validateDigits(string $input, $valids = null, ?array $context = null): bool
    {
        extract(static::_validsAndContext('digits', $valids, $context));

        // remove not digits
        $input = preg_replace('/\P{Nd}/u', '', $input);

        // remove valids
        $input = preg_replace('/[' . preg_quote($valids) . ']/', '', $input);

        return strlen($input) === 0;
    }

    /**
     * only valid symbols
     *
     * @param  string $input Input
     * @param  null|array|string $valids valid list OR context
     * @param  array|null $context Validation context
     * @return bool
     */
    public static function validateSymbols(string $input, $valids = null, ?array $context = null): bool
    {
        extract(static::_validsAndContext('symbols', $valids, $context));

        // remove alpha and digits
        $input = preg_replace('/[\p{L}\p{N}]/u', '', $input);

        // remove valids
        $input = preg_replace('/[' . preg_quote($valids) . ']/', '', $input);

        return strlen($input) === 0;
    }
}
