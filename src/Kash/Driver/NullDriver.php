<?php

namespace Kash\Driver;

/**
 */
class NullDriver implements DriverInterface
{
    public function getItem($key)
    {
    }

    public function clear()
    {
    }

    public function delete($key)
    {
    }

    public function save(CacheItemInterface $item)
    {
    }
}
