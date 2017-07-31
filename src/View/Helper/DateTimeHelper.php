<?php
namespace Ecl\View\Helper;

use Cake\Chronos\ChronosInterface;
use Cake\View\Helper;
use Ecl\I18n\DateTimeFormat;

class DateTimeHelper extends Helper
{
    public function date(ChronosInterface $date, $format = null, $timezone = null, $locale = null){
        return DateTimeFormat::date($date, $format, $timezone, $locale);
    }

    public function time(ChronosInterface $time, $format = null, $timezone = null, $locale = null){
        return DateTimeFormat::time($time, $format, $timezone, $locale);
    }
}
