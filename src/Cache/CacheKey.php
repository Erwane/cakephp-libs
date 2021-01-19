<?php
declare(strict_types=1);
namespace Ecl\Cache;

use Cake\Cache\Cache;
use Cake\Core\StaticConfigTrait;

/**
 * Class CacheKey
 *
 * @package Ecl\Cache
 */
class CacheKey
{
    use StaticConfigTrait;

    /**
     * Get a SimpleCacheEngine object for the named cache pool.
     *
     * @param  string $config The name of the configured cache backend.
     * @return \Cake\Cache\SimpleCacheEngine
     */
    public static function pool($config)
    {
        return Cache::pool($config);
    }

    /**
     * Write a key in the cache
     *
     * @param  string $cacheName Cache file name
     * @param  string $key Key in the cache
     * @param  mixed $value Value
     * @param  int $ttl Ttl for this key
     * @param  string $config Cache config
     * @return bool
     * @throws \Exception
     */
    public static function write(string $cacheName, string $key, $value, $ttl = 0, string $config = 'default')
    {
        if (is_resource($value)) {
            return false;
        }

        if (!is_numeric($ttl)) {
            $ttl = strtotime($ttl) - time();
        }

        if (empty($ttl)) {
            $ttl = 31536000; // 1 an
        }

        $backend = static::pool($config);

        $cache = (array)$backend->get($cacheName, []);

        $cache[$key] = [
            'expire' => time() + $ttl,
            'value' => $value,
        ];

        $cache = static::_cleanup($cache);

        return $backend->set($cacheName, $cache);
    }

    /**
     * Read a key from the cache
     *
     * @param  string $cacheName Cache file name
     * @param  string $key Key in the cache
     * @param  string $config Cache config
     * @return bool
     */
    public static function read($cacheName, $key, $config = 'default')
    {
        $backend = static::pool($config);

        $content = $backend->get($cacheName);

        if (isset($content[$key])) {
            // key expired ?
            if ($content[$key]['expire'] < time()) {
                return null;
            }

            return $content[$key]['value'];
        }

        return null;
    }

    /**
     * Cleanup cache, only 2 times on 3 to avoid to much parse
     *
     * @param  array $cache Input cache
     * @return array  Same or Cleaned cache
     * @throws \Exception
     * @throws \Exception
     */
    private static function _cleanup(array $cache)
    {
        // ignore cleaning 2 times on 3
        if (static::getConfig('cleaned') || random_int(1, 3) < 3) {
            return $cache;
        }

        $time = time();
        foreach ($cache as $key => $datas) {
            if ($datas['expire'] < $time) {
                unset($cache[$key]);
            }
        }

        static::setConfig('cleaned', true);

        return $cache;
    }
}
