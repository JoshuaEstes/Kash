<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash\Driver;

use Kash\CacheItemInterface;

/**
 * @since 0.1.0
 */
class NullDriver implements DriverInterface
{
    /**
     * {@inheritDoc}
     */
    public function has(CacheItemInterface $item)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function get(CacheItemInterface $item)
    {
        return $item;
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(CacheItemInterface $item)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function save(CacheItemInterface $item)
    {
        return true;
    }
}
