<?php
declare(strict_types=1);

namespace Ecl\Utility;

use Cake\Utility\Security as CakeSecurity;

/**
 * Class Security
 *
 * @package Ecl\Utility
 */
class Security extends CakeSecurity
{
    /**
     * Generate token
     *
     * @param  int $length Token length
     * @return string
     * @throws \Exception
     */
    public static function token(int $length = 8): string
    {
        $random = base64_encode(parent::randomBytes($length * 4));
        $clean = preg_replace('/[^A-Za-z0-9]/', '', $random);

        return substr($clean, random_int(1, $length * 2), $length);
    }

    /**
     * short hash of input
     *
     * @param  mixed $input input
     * @return string
     */
    public static function shortHash($input)
    {
        if (is_array($input)) {
            $input = serialize($input);
        }

        return substr(parent::hash($input, 'sha1'), 3, 16);
    }

    /**
     * unique alphanumerique hash
     * /!\ VERY SLOW /!\
     *
     * @param  string|array $input inpu
     * @return string 16 chars
     */
    public static function alphaHash($input)
    {
        if (is_array($input)) {
            $input = serialize($input);
        }

        $hash = password_hash($input, PASSWORD_BCRYPT, ['salt' => 'LpRjhRVpjD18lbQBNWcvQHeBtg8f9Z5n']);

        $hash = str_replace('$2y$10$', '', $hash);
        $hash = str_replace('.', '', $hash);
        $hash = str_replace('/', '', $hash);

        // return hash without key
        return substr($hash, 22, 16);
    }
}
