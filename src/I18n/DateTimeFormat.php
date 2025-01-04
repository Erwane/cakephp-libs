<?php
declare(strict_types=1);

/**
 * CakePHP Erwane libs
 * Copyright (c) Erwane BRETON
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Erwane BRETON
 * @see         https://github.com/Erwane/cakephp-libs
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Ecl\I18n;

use Cake\I18n\DateTime;

/**
 * Class DateTimeFormat
 */
class DateTimeFormat
{
    protected static ?string $_dateFormat = null;
    protected static ?string $_timeFormat = null;
    protected static ?string $_timezone = null;
    protected static ?string $_locale = null;

    /**
     * set date & time format in same method
     *
     * @param string $date ex 'dd BBB YYYY'
     * @param string $time ex 'HH:mm'
     * @return void
     */
    public static function setDateTimeFormat(string $date, string $time): void
    {
        self::setDateFormat($date);
        self::setTimeFormat($time);

        IoDateTimeFormat::ioDateTimeFormat($date, $time);
    }

    /**
     * set Date Format
     *
     * @param string $format Date Format
     * @return void
     */
    public static function setDateFormat(string $format): void
    {
        self::$_dateFormat = $format;

        IoDateTimeFormat::ioDateFormat($format);
    }

    /**
     * set Time Format
     *
     * @param string $format Time Format
     * @return void
     */
    public static function setTimeFormat(string $format): void
    {
        self::$_timeFormat = $format;
    }

    /**
     * set timezone
     *
     * @param string $timezone Timezone
     * @return void
     */
    public static function setTimezone(string $timezone): void
    {
        self::$_timezone = $timezone;
    }

    /**
     * set locale
     *
     * @param string $locale Locale
     * @return void
     */
    public static function setLocale(string $locale): void
    {
        self::$_locale = $locale;
    }

    /**
     * format date with app default format/timezone/locale
     *
     * @param \Cake\I18n\DateTime $date Date object
     * @param string|null $format output format
     * @param string|null $timezone timezone
     * @param string|null $locale locale
     * @return string                     formated date
     */
    public static function date(
        DateTime $date,
        ?string $format = null,
        ?string $timezone = null,
        ?string $locale = null
    ): string {
        if ($format === null) {
            $format = self::$_dateFormat;
        }

        if ($timezone === null) {
            $timezone = self::$_timezone;
        }

        if ($locale === null) {
            $locale = self::$_locale;
        }

        return $date->i18nFormat($format, $timezone, $locale);
    }

    /**
     * format time with app default format/timezone/locale
     *
     * @param \Cake\I18n\DateTime $time Date object
     * @param string|null $format output format
     * @param string|null $timezone timezone
     * @param string|null $locale locale
     * @return string                     formated time
     */
    public static function time(
        DateTime $time,
        ?string $format = null,
        ?string $timezone = null,
        ?string $locale = null
    ): string {
        if ($format === null) {
            $format = self::$_dateFormat . ' ' . self::$_timeFormat;
        }

        if ($timezone === null) {
            $timezone = self::$_timezone;
        }

        if ($locale === null) {
            $locale = self::$_locale;
        }

        return $time->i18nFormat($format, $timezone, $locale);
    }
}
