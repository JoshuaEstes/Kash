<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash;

use Kash\Driver\DriverInterface;
use Psr\Log\LoggerInterface;

/**
 * @since 0.1.0
 */
class CacheItem implements CacheItemInterface
{
    /**
     * @var DriverInterface
     * @since 0.1.0
     */
    protected $driver;

    /**
     * @var LoggerInterface
     * @since 0.1.0
     */
    protected $logger;

    /**
     * @var string
     * @since 0.1.0
     */
    protected $key;

    /**
     * @var mixed
     * @since 0.1.0
     */
    protected $value;

    /**
     * @var \DateTimeInterface
     * @since 0.1.0
     */
    protected $ttl;

    /**
     * @since 0.1.0
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @since 0.1.0
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @since 0.1.0
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @since 0.1.0
     * @param mixed $value
     * @return self
     */
    public function set($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function isHit()
    {
        $now = new \DateTime();
        $diff = $this->getExpiration()->diff($now);
        if (1 === $diff->invert) {
            return true;
        }

        return false;
    }

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function exists()
    {
        return false;
    }

    /**
     * @since 0.1.0
     * @param DateTime|null
     * @return self
     */
    public function setExpiration($ttl = null)
    {
        if (is_numeric($ttl)) {
            $expiresAt = new \DateTime();
            $expiresAt->add(new \DateInterval('PT'.$ttl.'S'));
            $this->ttl = $expiresAt;

            return $this;
        }

        if ($ttl instanceof \DateTime || null === $ttl) {
            $this->ttl = $ttl;

            return $this;
        }

        return $this;
    }

    public function getExpiration()
    {
        return $this->ttl;
    }
}
