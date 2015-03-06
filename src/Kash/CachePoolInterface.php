<?php

namespace Kash;

interface CachePoolInterface
{
    public function getItem($key);
    public function getItems(array $keys = array());
    public function clear();
    public function deleteItems(array $keys);
    public function save(CacheItemInterface $item);
    public function saveDeferred(CacheItemInterface $item);
    public function commit();
}
