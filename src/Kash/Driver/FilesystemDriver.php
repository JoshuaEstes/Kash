<?php
/**
 * @author Joshua Estes
 * @copyright 2015 Joshua Estes
 * @license https://raw.githubusercontent.com/JoshuaEstes/Kash/master/LICENSE MIT
 */

namespace Kash\Driver;

use Kash\CacheItemInterface;

/**
 * @since 0.1.0
 */
class FilesystemDriver implements DriverInterface
{
    /**
     * Path to store files at
     *
     * @var string
     */
    protected $path;

    /**
     * Filename extension
     *
     * @var string
     */
    const EXTENSION = 'cache';

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritDoc}
     */
    public function has(CacheItemInterface $item)
    {
        return $this->getFileInfo($item)->isFile();
    }

    /**
     * {@inheritDoc}
     */
    public function get(CacheItemInterface $item)
    {
        if ($this->has($item)) {
            $item = unserialize(file_get_contents($this->getFilename($item)));
        }

        return $item;
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $iterator = new \FilesystemIterator($this->path);
        /** @var \SplFileInfo */
        foreach ($iterator as $info) {
            if (self::EXTENSION === $info->getExtension()) {
                unlink($info->getPathName());
            }
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(CacheItemInterface $item)
    {
        if ($this->has($item)) {
            if (unlink($this->getFilename($item))) {
                return true;
            }

            throw new \Kash\CacheException(
                sprintf('Could not delete "%s".', $this->getFilename($item))
            );
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function save(CacheItemInterface $item)
    {
        $data = serialize($item);

        file_put_contents($this->getFilename($item), $data);

        return true;
    }

    /**
     * @param CacheItemInterface
     * @return string
     */
    protected function getFilename(CacheItemInterface $item)
    {
        return sprintf('%s/%s.%s', $this->path, $item->getKey(), self::EXTENSION);
    }

    /**
     * @param CacheItemInterface $item
     * @return \SplFileInfo
     */
    protected function getFileInfo(CacheItemInterface $item)
    {
        return new \SplFileInfo($this->getFilename($item));
    }
}
