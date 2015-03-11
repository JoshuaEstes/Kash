<?php

namespace Kash\Test;

use Kash\CacheItem;

class CacheItemTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $item = new CacheItem('test');
        $this->assertEquals('test', $item->getKey());
    }

    /**
     * @dataProvider stringDataProvider
     */
    public function testSetStrings($value)
    {
        $item = new CacheItem('key');
        $item->set($value);

        $this->assertInternalType('string', $item->get());
        $this->assertEquals($value, $item->get());
    }

    public function stringDataProvider()
    {
        return array(
            array('test'),
        );
    }

    /**
     * @dataProvider integerDataProvider
     */
    public function testSetIntegers($value)
    {
        $item = new CacheItem('key');
        $item->set($value);

        $this->assertInternalType('integer', $item->get());
        $this->assertEquals($value, $item->get());
    }

    public function integerDataProvider()
    {
        return array(
            array(11111111111),
        );
    }

    /**
     * @dataProvider floatDataProvider
     */
    public function testSetFloats($value)
    {
        $item = new CacheItem('key');
        $item->set($value);

        $this->assertInternalType('float', $item->get());
        $this->assertEquals($value, $item->get());
    }

    public function floatDataProvider()
    {
        return array(
            array(1.1),
        );
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testSetBooleans($value)
    {
        $item = new CacheItem('key');
        $item->set($value);

        $this->assertInternalType('boolean', $item->get());
        $this->assertEquals($value, $item->get());
    }

    public function booleanDataProvider()
    {
        return array(
            array(true),
            array(false),
        );
    }

    public function testSetNulls()
    {
        $value = null;
        $item  = new CacheItem('key');
        $item->set($value);

        $this->assertEquals($value, $item->get());
    }

    /**
     * @dataProvider arrayDataProvider
     */
    public function testSetArrays($value)
    {
        $item = new CacheItem('key');
        $item->set($value);

        $this->assertInternalType('array', $item->get());
        $this->assertEquals($value, $item->get());
    }

    public function arrayDataProvider()
    {
        return array(
            array(array()),
        );
    }

    /**
     * @dataProvider objectDataProvider
     */
    public function testSetObjects($value)
    {
        $item = new CacheItem('key');
        $item->set($value);

        $this->assertInternalType('object', $item->get());
        $this->assertEquals($value, $item->get());
    }

    public function objectDataProvider()
    {
        return array(
            array(new \stdClass()),
        );
    }

    public function testIsHit()
    {
        $driver = \Mockery::mock('Kash\Driver\DriverInterface');
        $driver->shouldReceive('hasItem')->andReturn(true);
        $item = new CacheItem('key');
        $item->setDriver($driver);
        $item->setExpiration(300);

        $this->assertTrue($item->exists(), 'Item does not exist in driver');
        $this->assertTrue($item->isHit(), 'Item was not a hit');
    }

    public function testIsMiss()
    {
        $item = new CacheItem('key');
        $item->setExpiration(0);

        $this->assertFalse($item->isHit());
    }

    public function testExists()
    {
        $item = new CacheItem('key');
        //$this->assertTrue($item->exists());
        //$this->assertFalse($item->exists());
    }

    public function testSetExpiration()
    {
        $item = new CacheItem('key');
        $item->setExpiration(new \DateTime());
    }

    public function testGetExpiration()
    {
        $item = new CacheItem('key');
        $this->assertNull($item->getExpiration());
    }
}
