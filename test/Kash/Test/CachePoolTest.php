<?php

namespace Kash\Test;

use Kash\CachePool;

class CachePoolTest extends \PHPUnit_Framework_TestCase
{
    public function testDown()
    {
        \Mockery::close();
    }

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
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('getItem'=>true));
        $pool = new CachePool($driver);
        $item = $pool->getItem($key);
        $this->assertInstanceOf('Kash\CacheItem', $item);
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
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidKeyDataProvider
     */
    public function testGetItemUsingInvalidKey($key)
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('getItem'=>true));
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
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('getItem'=>true));
        $pool = new CachePool($driver);
        $this->assertCount(0, $pool->getItems());
        $item = $pool->getItem('test');
        $this->assertCount(0, $pool->getItems());
        $this->assertCount(1, $pool->getItems(array('insert.key')));
    }

    public function testClear()
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('getItem'=>true,'clear'=>true));
        $pool = new CachePool($driver);
        for ($i = 0; $i < 10; $i++) {
            $pool->getItem($i);
        }
        $this->assertCount(0, $pool->getItems());
        $this->assertTrue($pool->clear());
    }

    public function testDeleteItems()
    {
        $mockItem = \Mockery::mock('Kash\CacheItemInterface');
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('getItem'=>$mockItem));
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
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('getItem'=>true));
        $driver->shouldReceive('save')->andReturn(\Mockery::self());
        $pool = new CachePool($driver);
        $item = $pool->getItem('test');
        $this->assertInstanceOf('Kash\CachePool', $pool->save($item));
    }

    public function testSaveDeferred()
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface', array('getItem'=>true));
        $driver->shouldReceive('save')->andReturn(\Mockery::self());
        $pool = new CachePool($driver);
        $item = $pool->getItem('test');
        $this->assertInstanceOf('Kash\CachePool', $pool->saveDeferred($item));
    }

    public function testCommit()
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface');
        $pool = new CachePool($driver);
        $this->assertTrue($pool->commit());
    }
}
