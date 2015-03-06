<?php

namespace Kash;

use Kash\Driver\DriverInterface;

/**
 */
class CachePool
{
    /**
     * regex pattern used to determine if a key is valid.
     *
     * @var string
     */
    const VALID_KEY_PATTERN = '[a-zA-Z0-9_\.]';

    protected $defaultTtl = 120; // Seconds
    protected $driver;

    /**
     * @var array
     */
    protected $itemsToSave;

    public function __construct(DriverInterface $driver)
    {
        $this->itemsToSave = array();
        $this->driver      = $driver;
    }

    public function __destruct()
    {
        $this->commit();
    }

    public function getItem($key)
    {
        $isInvalid = preg_replace('/'.self::VALID_KEY_PATTERN.'/', '', $key);

        if ('' !== $isInvalid) {
            throw new \InvalidArgumentException('Invalid key');
        }

        $item = new CacheItem($key);
        $item->set($this->driver->getItem($key));

        return $item;
    }

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

    public function clear()
    {
        $this->itemsToSave = array();

        return $this->driver->clear();
    }

    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            $this->driver->delete($key);
        }

        return $this;
    }

    public function save(CacheItem $item)
    {
        $this->driver->save($item);

        return $this;
    }

    public function saveDeferred(CacheItem $item)
    {
        $this->itemsToSave[] = $item;

        return $this;
    }

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
