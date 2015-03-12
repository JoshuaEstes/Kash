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
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return CacheItemInterface
     */
    public function get(CacheItemInterface $item);

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function clear();

    /**
     * @since 0.1.0
     */
    public function delete(CacheItemInterface $item);

    /**
     * @since 0.1.0
     */
    public function save(CacheItemInterface $item);
}
