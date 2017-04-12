<?php
namespace Ecl\Utility;

class Hash
{
    public static function partition($array, $part)
    {
        $listlen = count( $array );
        $partlen = floor( $listlen / $part );
        $partrem = $listlen % $part;
        $partition = array();
        $mark = 0;
        for ($px = 0; $px < $part; $px++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice( $array, $mark, $incr );
            $mark += $incr;
        }
        return $partition;
    }
}
