<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash;

use Kash\Driver\DriverInterface;

/**
 * @since 0.1.0
 */
class CachePool implements CachePoolInterface
{
    /**
     * regex pattern used to determine if a key is valid.
     *
     * @var string
     * @since 0.1.0
     */
    const VALID_KEY_PATTERN = '[a-zA-Z0-9_\.]';

    /**
     * @var integer
     * @since 0.1.0
     */
    protected $defaultTtl = 120; // Seconds

    /**
     * @var DriverInterface
     * @since 0.1.0
     */
    protected $driver;

    /**
     * @var array
     */
    protected $itemsToSave;

    /**
     * @param DriverInterface $driver
     * @since 0.1.0
     */
    public function __construct(DriverInterface $driver)
    {
        $this->itemsToSave = array();
        $this->driver      = $driver;
    }

    /**
     * @since 0.1.0
     */
    public function __destruct()
    {
        $this->commit();
    }

    /**
     * @since 0.1.0
     * @param string $key
     * @return CacheItemInterface
     */
    public function getItem($key)
    {
        $isInvalid = preg_replace('/'.self::VALID_KEY_PATTERN.'/', '', $key);

        if ('' !== $isInvalid) {
            throw new \InvalidArgumentException('Invalid key');
        }

        $item = $this->driver->get(new CacheItem($key));

        if (!($item instanceof \Kash\CacheItemInterface)) {
            throw new \Exception('Driver returned invalid item');
        }

        if (null === $item->getExpiration()) {
            $item->setExpiration($this->defaultTtl);
        }

        $item->setDriver($this->driver);

        return $item;
    }

    /**
     * @since 0.1.0
     * @param array $keys
     * @return array
     */
    public function getItems(array $keys = array())
    {
        if (0 === count($keys)) {
            return array();
        }

        $itemsToReturn = array();

        foreach ($keys as $key) {
            $itemsToReturn[$key] = $this->getItem($key);
        }

        return $itemsToReturn;
    }

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function clear()
    {
        $this->itemsToSave = array();

        return $this->driver->clear();
    }

    /**
     * @since 0.1.0
     * @param array $keys
     * @return self
     */
    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            $this->driver->delete(new CacheItem($key));
        }

        return $this;
    }

    /**
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return self
     */
    public function save(CacheItemInterface $item)
    {
        $this->driver->save($item);

        return $this;
    }

    /**
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return self
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        $this->itemsToSave[] = $item;

        return $this;
    }

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function commit()
    {
        $success = true;

        foreach ($this->itemsToSave as $item) {
            if (!$this->driver->save($item)) {
                $success = false;
            }
        }

        return $success;
    }
}
