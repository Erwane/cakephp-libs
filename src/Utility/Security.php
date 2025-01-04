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
namespace Ecl\Utility;

use Cake\Utility\Security as CakeSecurity;

/**
 * Class Security
 */
class Security extends CakeSecurity
{
    /**
     * Generate token
     *
     * @param int $length Token length
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
     * @param mixed $input input
     * @return string
     */
    public static function shortHash(mixed $input): string
    {
        if (is_array($input)) {
            $input = serialize($input);
        }

        return substr(parent::hash($input, 'sha1'), 3, 16);
    }

    /**
     * Unique alpha-numeric hash
     * /!\ VERY SLOW /!\
     *
     * @param array|string $input Input
     * @return string 16 chars
     */
    public static function alphaHash(string|array $input): string
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
