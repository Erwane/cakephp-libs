<?php
declare(strict_types=1);
namespace Ecl\I18n;

use Cake\Database\Type;
use Cake\I18n\Date as CakeDate;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;

/**
 * Class IoDateTimeFormat
 *
 * @package Ecl\I18n
 */
class IoDateTimeFormat
{

    /**
     * Set input date format in form (datepicker)
     *
     * @param string $format Format
     * @return void
     */
    public static function ioDateFormat($format): void
    {
        self::changeInputDateFormat($format);
        self::changeOutputDateFormat($format);
    }

    /**
     * Set input date time format in form (datepicker)
     *
     * @param string $dateFormat Date format
     * @param string $timeFormat Time format
     * @return void
     */
    public static function ioDateTimeFormat($dateFormat, $timeFormat = null): void
    {
        if ($timeFormat !== null) {
            self::ioDateFormat($dateFormat);
            $dateFormat = $dateFormat . ' ' . $timeFormat;
        }

        self::changeInputDateTimeFormat($dateFormat);
        self::changeOutputDateTimeFormat($dateFormat);
    }

    /**
     * Change input date type format
     *
     * @param  string $newFormat [description]
     * @return void
     */
    public static function changeInputDateFormat($newFormat = 'dd/MM/yyyy'): void
    {
        /** @var \Cake\Database\Type\DateType $type */
        $type = Type::build('date');
        $type->useLocaleParser()->setLocaleFormat($newFormat);
    }

    /**
     * Change input datetime type format
     *
     * @param  string $newFormat [description]
     * @return void
     */
    public static function changeInputDateTimeFormat($newFormat = 'dd/MM/yyyy HH:mm:ss'): void
    {
        /** @var \Cake\Database\Type\DateTimeType $type */
        $type = Type::build('datetime');
        $type->useLocaleParser()->setLocaleFormat($newFormat);
    }

    /**
     * Change output date format
     *
     * @param  string $newFormat [description]
     * @return void
     */
    public static function changeOutputDateFormat($newFormat = 'dd/MM/yyyy'): void
    {
        CakeDate::setToStringFormat($newFormat);
        FrozenDate::setToStringFormat($newFormat);
    }

    /**
     * Change output datetime format
     *
     * @param  string $newFormat [description]
     * @return void
     */
    public static function changeOutputDateTimeFormat($newFormat = 'dd-MM-yyyy HH:mm'): void
    {
        Time::setToStringFormat($newFormat);
        FrozenTime::setToStringFormat($newFormat);
    }
}
