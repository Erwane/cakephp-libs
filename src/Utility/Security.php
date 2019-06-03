<?php
namespace Ecl\Utility;

use Cake\Utility\Security as CakeSecurity;

class Security extends CakeSecurity
{
    public function token(int $length = 8)
    {
        $random = base64_encode(parent::randomBytes($length * 4));
        $clean = preg_replace('/[^A-Za-z0-9]/', '', $random);

        return substr($clean, random_int(1, $length * 2), $length);
    }
}
