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
namespace Ecl\View\Helper;

use Cake\I18n\DateTime;
use Cake\View\Helper;
use Ecl\I18n\DateTimeFormat;

/**
 * Class DateTimeHelper
 */
class DateTimeHelper extends Helper
{
    /**
     * @param \Cake\I18n\DateTime $date Input date
     * @param string|null $format Format
     * @param string|null $timezone Timezone
     * @param string|null $locale Locale
     * @return string
     */
    public function date(
        DateTime $date,
        ?string $format = null,
        ?string $timezone = null,
        ?string $locale = null
    ): string {
        return DateTimeFormat::date($date, $format, $timezone, $locale);
    }

    /**
     * @param \Cake\I18n\DateTime $time Input date
     * @param string|null $format Format
     * @param string|null $timezone Timezone
     * @param string|null $locale Locale
     * @return string
     */
    public function time(
        DateTime $time,
        ?string $format = null,
        ?string $timezone = null,
        ?string $locale = null
    ): string {
        return DateTimeFormat::time($time, $format, $timezone, $locale);
    }
}
