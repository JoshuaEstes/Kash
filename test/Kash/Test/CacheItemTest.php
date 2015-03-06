<?php

namespace Kash\Test;

use Kash\CacheItem;

class CacheItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CacheItem::__construct
     * @covers CacheItem::getKey
     */
    public function testConstruct()
    {
        $item = new CacheItem('test');
        $this->assertEquals('test', $item->getKey());
    }

    public function testSet()
    {
    }

    public function testGet()
    {
    }

    public function testIsHit()
    {
    }

    public function testExists()
    {
    }

    public function testSetExpiration()
    {
    }

    public function testGetExpiration()
    {
    }
}
