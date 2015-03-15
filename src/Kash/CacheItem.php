<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash;

use Kash\Driver\DriverInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * @since 0.1.0
 */
class CacheItem implements CacheItemInterface
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var LoggerInterface
     */
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
        $now  = new \DateTime();
        $diff = $now->diff($this->getExpiration());

        if (0 === $diff->invert && $this->exists()) {
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
        if (null === $this->driver) {
            return false;
        }

        return $this->driver->has($this);
    }

    /**
     * @since 0.1.0
     * @param DateTime|null
     * @return self
     */
    public function setExpiration($ttl = null)
    {
        if (is_numeric($ttl)) {
            $expiresAt = $this->getExpiration();
            while ($ttl > 60) {
                $expiresAt->add(new \DateInterval('PT60S'));
                $ttl -= 60;
            }

            if ($ttl < 60) {
                $expiresAt->add(new \DateInterval('PT'.$ttl.'S'));
            }

            $this->ttl = $expiresAt;
        } elseif ($ttl instanceof \DateTime || null === $ttl) {
            $this->ttl = $ttl;
        }

        return $this;
    }

    public function getExpiration()
    {
        if (null === $this->ttl) {
            return new \DateTime();
        }

        return $this->ttl;
    }

    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;
        $this->log(LogLevel::DEBUG, 'Driver set for "{key}".', array('key'=>$this->getKey()));

        return $this;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->log(LogLevel::DEBUG, 'Logger set for "{key}".', array('key'=>$this->getKey()));
    }

    /**
     * @since 0.1.0
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    protected function log($level, $message, array $context = array())
    {
        if (null === $this->logger) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}
