<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\I18n\FrozenTime;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Path constants to a few helpful things.
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
define('CORE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);
define('CAKE', CORE_PATH . 'src' . DS);

require_once CORE_PATH . 'config/bootstrap.php';

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);
FrozenTime::setTestNow('2021-01-02 15:30:25');
FrozenTime::setToStringFormat('y-MM-dd HH:mm:ss');
