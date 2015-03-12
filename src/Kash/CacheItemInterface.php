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
interface CacheItemInterface
{
    /**
     * Every CacheItem has a key which is a unique identifier
     *
     * @return string
     */
    public function getKey();

    /**
     * Returns the stored cached value
     *
     * @return mixed
     */
    public function get();

    /**
     * Sets the value of what is to be stored in the cache
     *
     * @param mixed $value
     * @return self
     */
    public function set($value);

    /**
     * If the item has been found and is not expired, it will return true
     *
     * @return boolean
     */
    public function isHit();

    /**
     * If the items exists in the cache
     *
     * @return boolean
     */
    public function exists();

    /**
     * Pass in the number of seconds to add time to the expiration time
     * Pass in a \DateTime object with the time it should expire
     * null will reset the expiration time
     *
     * @param int|\DateTime|null $ttl
     * @return self
     */
    public function setExpiration($ttl = null);

    /**
     * Returns the \DateTime object for when the item expires, if there has not
     * been an expiration time set, it will return the current \DateTime
     *
     * @return \DateTime
     */
    public function getExpiration();
}
