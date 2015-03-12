<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash\Test\Driver;

use Kash\Driver\ArrayDriver;

class ArrayDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testHasTrue()
    {
        $driver = new ArrayDriver();
        $item = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $driver = new ArrayDriver();
        $driver->save($item);

        $this->assertTrue($driver->has($item));
    }

    public function testHasFalse()
    {
        $driver = new ArrayDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $this->assertFalse($driver->has($item));
    }

    public function testGetThatHasBeenCached()
    {
        $driver = new ArrayDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $driver->save($item);

        $this->assertEquals($item, $driver->get($item));
    }

    public function testGetNew()
    {
        $driver = new ArrayDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');

        $this->assertEquals($item, $driver->get($item));
    }

    public function testClear()
    {
        $driver = new ArrayDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $driver->save($item);
        $this->assertTrue($driver->has($item));
        $this->assertTrue($driver->clear());
        $this->assertFalse($driver->has($item));
    }

    public function testDelete()
    {
        $driver = new ArrayDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $driver->save($item);
        $this->assertTrue($driver->has($item));
        $this->assertTrue($driver->clear());
        $this->assertFalse($driver->has($item));
    }

    public function testSave()
    {
        $driver = new ArrayDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $this->assertFalse($driver->has($item));
        $driver->save($item);
        $this->assertTrue($driver->has($item));
        $driver->delete($item);
        $this->assertFalse($driver->has($item));
    }
}
