<?php
declare(strict_types=1);

namespace Ecl\Utility;

/**
 * Class Hash
 *
 * @package Ecl\Utility
 */
class Hash
{
    /**
     * @param array $array Input
     * @param int $part Wanted partitions
     * @return array
     */
    public static function partition($array, $part): array
    {
        $listlen = count($array);
        $partlen = floor($listlen / $part);
        $partrem = $listlen % $part;
        $partition = [];
        $mark = 0;
        for ($px = 0; $px < $part; $px++) {
            $incr = $px < $partrem ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice($array, $mark, $incr);
            $mark += $incr;
        }

        return $partition;
    }
}
