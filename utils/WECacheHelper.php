<?php 
namespace app\utils;

use Yii;
class WECacheHelper {

    public $cache;

    public $timeout;

    public function __construct($timeout = 3600) {
        $this->cache = Yii::$app->cache;
        $this->timeout = 3600;
    }

    public function set($key, $data) {
        $this->cache->set($key, $data, $this->timeout);
    }

    public function get($key, $callback = null) {
        if(is_callable($callback)) {
            return $this->cache->getOrSet($key, $callback);
        } else {
            return $this->cache->get($key);
        }
    } 
}