<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash\Test\Driver;

use Kash\Driver\FilesystemDriver;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * FilesystemDriver Tests
 *
 * This class is used to run various tests on the filesystem driver.
 */
class FilesystemDriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    protected function setUp()
    {
        $this->root = vfsStream::setup('root');
    }

    /**
     * Test has() function
     */
    public function testHas()
    {
        $faker = \Faker\Factory::create();
        $value = $faker->paragraph;
        $item  = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $item->shouldReceive('get')->andReturn($value);

        $driver = new FilesystemDriver(vfsStream::url('root'));
        $this->assertFalse($driver->has($item));

        $driver->save($item);

        $this->assertTrue($driver->has($item));
    }

    /**
     * Test that shows that if an item is not cached, it will return
     * the same CacheItem that was returned.
     */
    public function testGet()
    {
        $item = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $driver = new FilesystemDriver(vfsStream::url('root'));
        $this->assertSame($item, $driver->get($item));
        $this->assertTrue($driver->save($item));
        $this->assertThat(
            $item,
            $this->logicalNot(
                $this->equalTo($driver->get($item))
            )
        );
    }

    public function testClear()
    {
        $item = \Mockery::mock('Kash\CacheItemInterface');
        $item->shouldReceive('getKey')->andReturn('test.key');
        $driver = new FilesystemDriver(vfsStream::url('root'));
        $this->assertFalse($driver->has($item), 'Item was not expected to be found');
        $this->assertTrue($driver->save($item), '->save() did not return true');
        $this->assertTrue($driver->has($item), 'Item was expected to be found');
        $this->assertTrue($driver->clear(), '->clear() did not return true');
        $this->assertFalse($driver->has($item), 'Item was not expected to be found');
    }

    public function testDelete()
    {
        $itemA = \Mockery::mock('Kash\CacheItemInterface');
        $itemA->shouldReceive('getKey')->andReturn('test.key.a');

        $itemB = \Mockery::mock('Kash\CacheItemInterface');
        $itemB->shouldReceive('getKey')->andReturn('test.key.b');

        $driver = new FilesystemDriver(vfsStream::url('root'));

        // Does not have items cached
        $this->assertFalse($driver->has($itemA));
        $this->assertFalse($driver->has($itemB));

        // cache items
        $this->assertTrue($driver->save($itemA));
        $this->assertTrue($driver->save($itemB));

        // make sure they are there
        $this->assertTrue($driver->has($itemA));
        $this->assertTrue($driver->has($itemB));

        // delete one item
        $this->assertTrue($driver->delete($itemA));

        // make sure item is no longer there
        $this->assertFalse($driver->has($itemA));

        // make sure other item was not deleted
        $this->assertTrue($driver->has($itemB));
    }
}
