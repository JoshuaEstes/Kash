<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash\Driver;

use Kash\CacheItem;
use Kash\CacheItemInterface;

/**
 * @since 0.1.0
 */
class ArrayDriver implements DriverInterface
{
    /**
     * Holds all the items
     *
     * @var array
     */
    protected $items;

    /**
     * @since 0.1.0
     */
    public function __construct()
    {
        $this->items = array();
    }

    /**
     * {@inheritDoc}
     */
    public function has(CacheItemInterface $item)
    {
        return isset($this->items[$item->getKey()]);
    }

    /**
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return CacheItemInterface
     */
    public function get(CacheItemInterface $item)
    {
        if (isset($this->items[$item->getKey()])) {
            return $this->items[$item->getKey()];
        }

        return $item;
    }

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function clear()
    {
        $this->items = array();

        return true;
    }

    /**
     * @since 0.1.0
     * @param CacheItemInterface $item
     */
    public function delete(CacheItemInterface $item)
    {
        if (isset($this->items[$item->getKey()])) {
            unset($this->items[$item->getKey()]);
        }
    }

    /**
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return boolean
     */
    public function save(CacheItemInterface $item)
    {
        $this->items[$item->getKey()] = $item;

        return true;
    }
}
