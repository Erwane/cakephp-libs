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
namespace Ecl\I18n;

use Cake\Database\TypeFactory;
use Cake\I18n\Date as CakeDate;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;

/**
 * Class IoDateTimeFormat
 */
class IoDateTimeFormat
{
    /**
     * Set input date format in form (datepicker)
     *
     * @param string $format Format
     * @return void
     */
    public static function ioDateFormat(string $format): void
    {
        self::changeInputDateFormat($format);
        self::changeOutputDateFormat($format);
    }

    /**
     * Set input date time format in form (datepicker)
     *
     * @param string $dateFormat Date format
     * @param string|null $timeFormat Time format
     * @return void
     */
    public static function ioDateTimeFormat(string $dateFormat, ?string $timeFormat = null): void
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
     * @param string $newFormat [description]
     * @return void
     */
    public static function changeInputDateFormat(string $newFormat = 'dd/MM/yyyy'): void
    {
        /** @var \Cake\Database\Type\DateType $type */
        $type = TypeFactory::build('date');
        $type->useLocaleParser()->setLocaleFormat($newFormat);
    }

    /**
     * Change input datetime type format
     *
     * @param string $newFormat [description]
     * @return void
     */
    public static function changeInputDateTimeFormat(string $newFormat = 'dd/MM/yyyy HH:mm:ss'): void
    {
        /** @var \Cake\Database\Type\DateTimeType $type */
        $type = TypeFactory::build('datetime');
        $type->useLocaleParser()->setLocaleFormat($newFormat);
    }

    /**
     * Change output date format
     *
     * @param string $newFormat [description]
     * @return void
     */
    public static function changeOutputDateFormat(string $newFormat = 'dd/MM/yyyy'): void
    {
        CakeDate::setToStringFormat($newFormat);
        FrozenDate::setToStringFormat($newFormat);
    }

    /**
     * Change output datetime format
     *
     * @param string $newFormat [description]
     * @return void
     */
    public static function changeOutputDateTimeFormat(string $newFormat = 'dd-MM-yyyy HH:mm'): void
    {
        Time::setToStringFormat($newFormat);
        FrozenTime::setToStringFormat($newFormat);
    }
}
