<?php

namespace Kash;

interface CacheItemInterface
{
    public function getKey();
    public function get();
    public function set($value);
    public function isHit();
    public function exists();
    public function setExpiration($ttl = null);
    public function getExpiration();
}
