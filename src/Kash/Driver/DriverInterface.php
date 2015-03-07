<?php

namespace Kash\Driver;

use Kash\CacheItemInterface;

/**
 */
interface DriverInterface
{
    public function hasItem($key);
    public function getItem($key);
    public function clear();
    public function deleteItem($key);
    public function save(CacheItemInterface $item);
}
