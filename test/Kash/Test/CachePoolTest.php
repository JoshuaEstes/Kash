<?php

namespace Kash\Test;

use Kash\CachePool;
use Kash\CacheItem;
use Psr\Log\LoggerInterface;

class CachePoolTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface');
        $pool = new CachePool($driver);
    }

    /**
     * @dataProvider validKeyDataProvider
     */
    public function testGetItem($key)
    {
        $mockDriver = \Mockery::mock('Kash\Driver\DriverInterface');
        $mockDriver->shouldReceive('get')->andReturn(new CacheItem($key));
        $pool = new CachePool($mockDriver);
        $item = $pool->getItem($key);
        $this->assertInstanceOf('Kash\CacheItemInterface', $item);
        $this->assertEquals($key, $item->getKey());
    }

    public function validKeyDataProvider()
    {
        return array(
            array('test'),
            array('test.test'),
            array('test0'),
            array('test_test'),
            array('.test'),
            array('.test09'),
        );
    }

    /**
     * @expectedException \Exception
     */
    public function testGetItemWhereDriverDoesNotReturnCacheItem()
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface');
        $driver->shouldReceive('get')->andReturn(false);
        $pool = new CachePool($driver);
        $pool->getItem('blow.up');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidKeyDataProvider
     */
    public function testGetItemUsingInvalidKey($key)
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('get'=>true));
        $pool = new CachePool($driver);
        $pool->getItem($key);
    }

    public function invalidKeyDataProvider()
    {
        return array(
            array('this is a test'),
            array('contains"invalid$'),
        );
    }

    public function testGetItems()
    {
        $mockItem = \Mockery::mock('Kash\CacheItemInterface');
        $mockItem->shouldReceive('setExpiration');
        $mockItem->shouldReceive('setDriver');
        $mockItem->shouldReceive('getExpiration')->andReturn(null);
        $mockDriver = \Mockery::mock('Kash\Driver\DriverInterface');
        $mockDriver->shouldReceive('get')->andReturn($mockItem);
        $pool = new CachePool($mockDriver);
        $this->assertCount(0, $pool->getItems());
        $item = $pool->getItem('test');
        $this->assertCount(0, $pool->getItems());
        $this->assertCount(1, $pool->getItems(array('insert.key')));
    }

    public function testClear()
    {
        $mockItem = \Mockery::mock('Kash\CacheItemInterface');
        $mockItem->shouldReceive('setExpiration');
        $mockItem->shouldReceive('setDriver');
        $mockItem->shouldReceive('getExpiration')->andReturn(null);
        $mockDriver = \Mockery::mock('Kash\Driver\DriverInterface');
        $mockDriver->shouldReceive('get')->andReturn($mockItem);
        $mockDriver->shouldReceive('clear')->andReturn(true);
        $pool = new CachePool($mockDriver);
        for ($i = 0; $i < 10; $i++) {
            $pool->getItem($i);
        }
        $this->assertCount(0, $pool->getItems());
        $this->assertTrue($pool->clear());
    }

    public function testDeleteItems()
    {
        $mockItem = \Mockery::mock('Kash\CacheItemInterface');
        $mockItem->shouldReceive('setExpiration');
        $mockItem->shouldReceive('setDriver');
        $mockItem->shouldReceive('getExpiration')->andReturn(null);
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('get'=>$mockItem));
        $driver->shouldReceive('delete')->andReturn(\Mockery::self());
        $pool = new CachePool($driver);
        for ($i = 0; $i < 10; $i++) {
            $pool->getItem($i);
        }
        $this->assertCount(0, $pool->getItems());
        $pool->deleteItems(array('1','5'));
        $this->assertCount(0, $pool->getItems());
    }

    public function testSave()
    {
        $mockItem = \Mockery::mock('Kash\CacheItemInterface');
        $mockItem->shouldReceive('setExpiration');
        $mockItem->shouldReceive('setDriver');
        $mockItem->shouldReceive('getExpiration')->andReturn(null);
        $mockDriver = \Mockery::mock('Kash\Driver\DriverInterface');
        $mockDriver->shouldReceive('get')->andReturn($mockItem);
        $mockDriver->shouldReceive('save')->andReturn(\Mockery::self());
        $pool = new CachePool($mockDriver);
        $item = $pool->getItem('test');
        $this->assertInstanceOf('Kash\CacheItemInterface', $item);
        $this->assertInstanceOf('Kash\CachePoolInterface', $pool->save($item));
    }

    public function testSaveDeferred()
    {
        $mockItem = \Mockery::mock('Kash\CacheItemInterface');
        $mockItem->shouldReceive('setExpiration');
        $mockItem->shouldReceive('setDriver');
        $mockItem->shouldReceive('getExpiration')->andReturn(null);
        $mockDriver = \Mockery::mock('Kash\Driver\DriverInterface');
        $mockDriver->shouldReceive('get')->andReturn($mockItem);
        $mockDriver->shouldReceive('save')->andReturn(\Mockery::self());
        $pool = new CachePool($mockDriver);
        $item = $pool->getItem('test');
        $this->assertInstanceOf('Kash\CachePoolInterface', $pool->saveDeferred($item));
    }

    public function testCommit()
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface');
        $pool   = new CachePool($driver);
        $this->assertTrue($pool->commit());
    }

    public function testCommitFailure()
    {
        $mockItem = \Mockery::mock('Kash\CacheItemInterface');
        $mockItem->shouldReceive('setExpiration');
        $mockItem->shouldReceive('setDriver');
        $mockItem->shouldReceive('getExpiration')->andReturn(null);
        $driver   = \Mockery::mock('Kash\Driver\DriverInterface');
        $driver->shouldReceive('get')->andReturn($mockItem);
        $driver->shouldReceive('save')->andReturn(false);
        $pool = new CachePool($driver);
        $pool->saveDeferred($pool->getItem('dererred.item'));
        $this->assertFalse($pool->commit());
    }
}
