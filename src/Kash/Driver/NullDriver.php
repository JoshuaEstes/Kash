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
    public function has(CacheItemInterface $item)
    {
        return false;
    }

    public function get(CacheItemInterface $item)
    {
        return $item;
    }

    public function clear()
    {
        return true;
    }

    public function delete(CacheItemInterface $item)
    {
    }

    public function save(CacheItemInterface $item)
    {
    }
}
