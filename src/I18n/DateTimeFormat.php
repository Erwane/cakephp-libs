<?php
namespace Ecl\I18n;

use Cake\Chronos\ChronosInterface;

class DateTimeFormat
{
    protected static $_date_format = null;
    protected static $_time_format = null;
    protected static $_timezone = null;
    protected static $_locale = null;

    /**
     * set date & time format in same method
     * @param string $date ex 'dd BBB YYYY'
     * @param string $time ex 'HH:mm'
     */
    public static function setDateTimeFormat($date, $time)
    {
        self::setDateFormat($date);
        self::setTimeFormat($time);

        IoDateTimeFormat::ioDateTimeFormat($date, $time);
    }

    /**
     * set Date Format
     * @param string $format Date Format
     */
    public static function setDateFormat($format)
    {
        self::$_date_format = $format;

        IoDateTimeFormat::ioDateFormat($format);
    }

    /**
     * set Time Format
     * @param string $format Time Format
     */
    public static function setTimeFormat($format)
    {
        self::$_time_format = $format;
    }

    /**
     * set timezone
     * @param string $timezone Timezone
     */
    public static function setTimezone($timezone)
    {
        self::$_timezone = $timezone;
    }

    /**
     * set locale
     * @param string $locale Locale
     */
    public static function setLocale($locale)
    {
        self::$_locale = $locale;
    }

    /**
     * format date with app default format/timezone/locale
     * @param  ChronosInterface $date   Date object
     * @param  null|string $format      output format
     * @param  null|string $timezone    timezone
     * @param  null|string $locale      locale
     * @return date                     formated date
     */
    public static function date(ChronosInterface $date, $format = null, $timezone = null, $locale = null)
    {
        if (empty($date)) {
            return '';
        }

        if ($format === null) {
            $format = self::$_date_format;
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
     * @param  ChronosInterface $time   Date object
     * @param  null|string $format      output format
     * @param  null|string $timezone    timezone
     * @param  null|string $locale      locale
     * @return time                     formated time
     */
    public static function time(ChronosInterface $time, $format = null, $timezone = null, $locale = null)
    {
        if (empty($time)) {
            return '';
        }

        if ($format === null) {
            $format = self::$_date_format . ' ' . self::$_time_format;
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
