<?php

class RedisCache extends CCache
{
    public $servers = array();

    /**
     * @var Redis
     */
    protected $_cache;

    const CACHE_PREFIX = "cache:mytest:";

    public function init()
    {
        $this->_cache = new RedisArray($this->servers);
        parent::init();
    }

    /**
     * Retrieves a value from cache with a specified key.
     * This is the implementation of the method declared in the parent class.
     * @param string $key a unique key identifying the cached value
     * @return string the value stored in cache, false if the value is not in the cache or expired.
     */
    public function getValue($key)
    {
        return $this->_cache->get($this->getKey($key));
    }

    /**
     * Stores a value identified by a key in cache.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key the key identifying the value to be cached
     * @param string $value the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    public function setValue($key, $value, $expire)
    {
        return $this->_cache->set(
            $this->getKey($key),
            $value,
            $expire
        );
    }

    /**
     * call unusual method
     * */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->_cache, $method), $args);
    }

    /**
     * Возвращает ключ с префиксом
     * @param string $key
     * @return string
     */
    protected function getKey($key){
        return self::CACHE_PREFIX . $key;
    }

}
