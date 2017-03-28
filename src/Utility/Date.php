<?php
namespace Ecl\Utility;

use Cake\Database\Type;

class Date
{
    /**
     * [changeInputDateFormat description]
     * @param  string $newFormat [description]
     * @return [type]            [description]
     */
    public static function changeInputDateFormat($newFormat = 'dd/MM/yyyy')
    {
        Type::build('date')->useLocaleParser()->setLocaleFormat($newFormat);
    }

    /**
     * [changeInputDateFormat description]
     * @param  string $newFormat [description]
     * @return [type]            [description]
     */
    public static function changeInputDateTimeFormat($newFormat = 'dd/MM/yyyy HH:mm:ss')
    {
        Type::build('datetime')->useLocaleParser()->setLocaleFormat($newFormat);
    }

    /**
     * [changeInputDateFormat description]
     * @param  string $newFormat [description]
     * @return [type]            [description]
     */
    public static function changeOutputDateFormat($newFormat = 'dd/MM/yyyy')
    {
        FrozenDate::setToStringFormat($newFormat);
    }

    /**
     * [changeInputDateFormat description]
     * @param  string $newFormat [description]
     * @return [type]            [description]
     */
    public static function changeOutputDateTimeFormat($newFormat = 'dd-MM-yyyy HH:mm')
    {
        FrozenTime::setToStringFormat($newFormat);
    }
}
