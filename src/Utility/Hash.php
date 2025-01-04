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

/**
 * Class Hash
 */
class Hash
{
    /**
     * @param array $array Input
     * @param int $part Wanted partitions
     * @return array
     */
    public static function partition(array $array, int $part): array
    {
        $listLen = count($array);
        $partLen = floor($listLen / $part);
        $partRem = $listLen % $part;
        $partition = [];
        $mark = 0;
        for ($px = 0; $px < $part; $px++) {
            $incr = $px < $partRem ? $partLen + 1 : $partLen;
            $partition[$px] = array_slice($array, $mark, $incr);
            $mark += $incr;
        }

        return $partition;
    }
}
