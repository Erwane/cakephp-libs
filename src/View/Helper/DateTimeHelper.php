<?php
namespace Ecl\View\Helper;

use Cake\Chronos\ChronosInterface;
use Cake\View\Helper;
use Ecl\I18n\DateTimeFormat;

class DateTimeHelper extends Helper
{
    public function time(ChronosInterface $time, $format = null, $timezone = null, $locale = null){
        return DateTimeFormat($time, $format, $timezone, $locale);
    }
}
