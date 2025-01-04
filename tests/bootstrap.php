<?php
declare(strict_types=1);

use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\I18n\DateTime;
use Cake\Utility\Security;

require_once dirname(__DIR__) . '/vendor/autoload.php';

define('ROOT', dirname(__DIR__) . DS);
define('TMP', sys_get_temp_dir() . DS);
const CORE_PATH = ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS;
const CAKE = CORE_PATH . 'src' . DS;

require CAKE . 'Core/functions_global.php';

Configure::write('debug', true);
Configure::write('App.encoding', 'UTF-8');
Security::setSalt('a-long-but-not-random-value');
Chronos::setTestNow('2021-01-02 15:30:25');
DateTime::setToStringFormat('y-MM-dd HH:mm:ss');
