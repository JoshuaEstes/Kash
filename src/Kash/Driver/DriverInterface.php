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
interface DriverInterface
{
    /**
     * Returns true if the item exists in it's cache
     *
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return boolean
     */
    public function has(CacheItemInterface $item);

    /**
     * Uses a CacheItemInterface to find the item in the backend. If the item
     * is found it returns that item. If it is not found it should pass back
     * the original item passed to it.
     *
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return CacheItemInterface
     */
    public function get(CacheItemInterface $item);

    /**
     * Clears the entire cache backend of cached items. If successful it should
     * return true. If there was an error, it should throw a CacheException
     *
     * @since 0.1.0
     * @throws CacheException
     * @return boolean
     */
    public function clear();

    /**
     * Delete an item from the cache backend using the item passed into it. It
     * should return true if the item was successfully deleted, if any issues
     * happen it should throw a CacheException
     *
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @throws CacheException
     * @return boolean
     */
    public function delete(CacheItemInterface $item);

    /**
     * Persists an item to the backend cache. Returns true if successful or
     * throws a CacheException if there was an error.
     *
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @throws CacheException
     * @return boolean
     */
    public function save(CacheItemInterface $item);
}
