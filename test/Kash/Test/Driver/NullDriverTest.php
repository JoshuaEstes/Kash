<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash\Test\Driver;

use Kash\Driver\NullDriver;

class NullDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testHas()
    {
        $item = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $driver = new NullDriver();
        $driver->save($item);

        $this->assertFalse($driver->has($item));
    }

    public function testGet()
    {
        $driver = new NullDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $this->assertTrue($driver->save($item));
        $this->assertEquals($item, $driver->get($item));
    }

    public function testClear()
    {
        $driver = new NullDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $this->assertFalse($driver->has($item));
        $this->assertTrue($driver->save($item));
        $this->assertFalse($driver->has($item));
        $this->assertTrue($driver->clear());
        $this->assertFalse($driver->has($item));
    }

    public function testDelete()
    {
        $driver = new NullDriver();
        $item   = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $this->assertFalse($driver->has($item));
        $this->assertTrue($driver->save($item));
        $this->assertFalse($driver->has($item));
        $this->assertTrue($driver->delete($item));
        $this->assertFalse($driver->has($item));
    }
}
