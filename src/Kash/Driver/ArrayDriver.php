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
    protected $items;

    public function __construct()
    {
        $this->items = array();
    }

    public function hasItem(CacheItemInterface $item)
    {
        return isset($this->items[$item->getKey()]);
    }

    public function getItem($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        return new CacheItem($key);
    }

    public function clear()
    {
        $this->items = array();

        return true;
    }

    public function deleteItem($key)
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    public function save(CacheItemInterface $item)
    {
        $this->items[$item->getKey()] = $item;
    }
}
