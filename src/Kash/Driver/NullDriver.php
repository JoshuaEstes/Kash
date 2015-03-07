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
 */
class NullDriver implements DriverInterface
{
    public function hasItem($key)
    {
        return false;
    }

    public function getItem($key)
    {
        return new CacheItem($key);
    }

    public function clear()
    {
        return true;
    }

    public function deleteItem($key)
    {
    }

    public function save(CacheItemInterface $item)
    {
    }
}
