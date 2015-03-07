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
     * @since 0.1.0
     * @param string $key
     * @return boolean
     */
    public function hasItem($key);

    /**
     * @since 0.1.0
     * @param string $key
     * @return CacheItemInterface
     */
    public function getItem($key);

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function clear();

    /**
     * @since 0.1.0
     */
    public function deleteItem($key);

    /**
     * @since 0.1.0
     */
    public function save(CacheItemInterface $item);
}
