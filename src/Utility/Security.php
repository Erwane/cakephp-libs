<?php
namespace Ecl\Utility;

class Security
{
    public function token(int $length = 8)
    {
        $random = base64_encode(openssl_random_pseudo_bytes($length * 4));
        $clean = preg_replace('/[^A-Za-z0-9]/', '', $random);

        return substr($clean, mt_rand(1, $length * 2), $length);
    }
}
