<?php
declare(strict_types=1);

namespace Ecl\View\Helper;

use Cake\I18n\DateFormatTrait;
use Cake\View\Helper;
use Ecl\I18n\DateTimeFormat;

/**
 * Class DateTimeHelper
 *
 * @package Ecl\View\Helper
 */
class DateTimeHelper extends Helper
{
    /**
     * @param  \Cake\I18n\DateFormatTrait $date Input date
     * @param  string|null $format Format
     * @param  string|null $timezone Timezone
     * @param  string|null $locale Locale
     * @return string
     */
    public function date(DateFormatTrait $date, $format = null, $timezone = null, $locale = null)
    {
        return DateTimeFormat::date($date, $format, $timezone, $locale);
    }

    /**
     * @param  \Cake\I18n\DateFormatTrait $time Input date
     * @param  string|null $format Format
     * @param  string|null $timezone Timezone
     * @param  string|null $locale Locale
     * @return string
     */
    public function time(DateFormatTrait $time, $format = null, $timezone = null, $locale = null)
    {
        return DateTimeFormat::time($time, $format, $timezone, $locale);
    }
}
