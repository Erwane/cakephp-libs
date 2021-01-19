<?php
declare(strict_types=1);
namespace Ecl\I18n;

use Cake\I18n\DateFormatTrait;

/**
 * Class DateTimeFormat
 *
 * @package Ecl\I18n
 */
class DateTimeFormat
{
    protected static $_dateFormat = null;
    protected static $_timeFormat = null;
    protected static $_timezone = null;
    protected static $_locale = null;

    /**
     * set date & time format in same method
     *
     * @param  string $date ex 'dd BBB YYYY'
     * @param  string $time ex 'HH:mm'
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
     * @param  string $format Date Format
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
     * @param  string $format Time Format
     * @return void
     */
    public static function setTimeFormat($format): void
    {
        self::$_timeFormat = $format;
    }

    /**
     * set timezone
     *
     * @param  string $timezone Timezone
     * @return void
     */
    public static function setTimezone($timezone): void
    {
        self::$_timezone = $timezone;
    }

    /**
     * set locale
     *
     * @param  string $locale Locale
     * @return void
     */
    public static function setLocale($locale): void
    {
        self::$_locale = $locale;
    }

    /**
     * format date with app default format/timezone/locale
     *
     * @param  \Cake\I18n\DateFormatTrait $date Date object
     * @param  null|string $format output format
     * @param  null|string $timezone timezone
     * @param  null|string $locale locale
     * @return string                     formated date
     */
    public static function date(DateFormatTrait $date, $format = null, $timezone = null, $locale = null): string
    {
        if (empty($date)) {
            return '';
        }

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
     * @param  \Cake\I18n\DateFormatTrait $time Date object
     * @param  null|string $format output format
     * @param  null|string $timezone timezone
     * @param  null|string $locale locale
     * @return string                     formated time
     */
    public static function time(DateFormatTrait $time, $format = null, $timezone = null, $locale = null): string
    {
        if (empty($time)) {
            return '';
        }

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
