<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash;

/**
 * @since 0.1.0
 */
interface CachePoolInterface
{
    /**
     * @since 0.1.0
     * @param string $key
     * @throws CacheException
     * @return CacheItemInterface
     */
    public function getItem($key);

    /**
     * @since 0.1.0
     * @param array $keys
     * @return array
     */
    public function getItems(array $keys = array());

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function clear();

    /**
     * @since 0.1.0
     * @param array $keys
     * @return self
     */
    public function deleteItems(array $keys);

    /**
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return self
     */
    public function save(CacheItemInterface $item);

    /**
     * @since 0.1.0
     * @param CacheItemInterface $item
     * @return self
     */
    public function saveDeferred(CacheItemInterface $item);

    /**
     * @since 0.1.0
     * @return boolean
     */
    public function commit();
}
