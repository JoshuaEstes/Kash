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
     * @var array
     */
    protected $items;

    /**
     */
    public function __construct()
    {
        $this->items = array();
    }

    /**
     */
    public function has(CacheItemInterface $item)
    {
        return isset($this->items[$item->getKey()]);
    }

    /**
     */
    public function get(CacheItemInterface $item)
    {
        if (isset($this->items[$item->getKey()])) {
            return $this->items[$item->getKey()];
        }

        return $item;
    }

    public function clear()
    {
        $this->items = array();

        return true;
    }

    public function delete(CacheItemInterface $item)
    {
        if (isset($this->items[$item->getKey()])) {
            unset($this->items[$item->getKey()]);
        }
    }

    public function save(CacheItemInterface $item)
    {
        $this->items[$item->getKey()] = $item;

        return true;
    }
}
