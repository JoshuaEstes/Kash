<?php

namespace Kash;

/**
 */
class CacheItem implements CacheItemInterface
{
    protected $driver;
    protected $logger;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var \DateTimeInterface
     */
    protected $ttl;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    public function get()
    {
        return $this->value;
    }

    public function set($value)
    {
        $this->value = $value;
    }

    public function isHit()
    {
        /**
         * Return true if not expired and value is valid
         */
        return true;
    }

    public function exists()
    {
    }

    public function setExpiration($ttl = null)
    {
        $this->ttl = $ttl;
    }

    public function getExpiration()
    {
    }
}
