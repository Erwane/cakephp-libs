<?php
namespace Ecl\I18n;

use Cake\Database\Type;
use Cake\I18n\Date as CakeDate;
use Cake\I18n\FrozenDate;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

class IoDateTimeFormat
{

    public static function ioDateFormat($format)
    {
        self::changeInputDateFormat($format);
        self::changeOutputDateFormat($format);
    }

    public static function ioDateTimeFormat($dateFormat, $timeFormat = null)
    {
        if ($timeFormat !== null) {
            self::ioDateFormat($dateFormat);
            $dateFormat = $dateFormat . ' ' . $timeFormat;
        }

        self::changeInputDateTimeFormat($dateFormat);
        self::changeOutputDateTimeFormat($dateFormat);
    }

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
        CakeDate::setToStringFormat($newFormat);
        FrozenDate::setToStringFormat($newFormat);
    }

    /**
     * [changeInputDateFormat description]
     * @param  string $newFormat [description]
     * @return [type]            [description]
     */
    public static function changeOutputDateTimeFormat($newFormat = 'dd-MM-yyyy HH:mm')
    {
        Time::setToStringFormat($newFormat);
        FrozenTime::setToStringFormat($newFormat);
    }
}
