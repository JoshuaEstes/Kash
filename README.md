Kash/Kash [![Travis](https://img.shields.io/travis/JoshuaEstes/Kash.svg)](https://travis-ci.org/JoshuaEstes/Kash) [![Packagist Pre Release](https://img.shields.io/packagist/vpre/kash/kash.svg)](https://packagist.org/packages/kash/kash) [![Packagist](https://img.shields.io/packagist/v/kash/kash.svg)](https://packagist.org/packages/kash/kash)
=========

Kash is a general purpose caching library that is used to cache various values
using a variety of different drivers to accomplish this.

* Database results
* User sessions
* API Calls

# Features

* Fast
* Supports
  * Filesystem
  * APC
  * Redis
  * Memcached
  * PDO
  * Null
* Extra drivers that are able to support multiple backends
* Uses PSR-3 standard for logging
* Heavily Tested, Commented, and Quality Controlled

# Installation

## Composer (Preferred)

This assumes you have [composer] installed. Once you do that please run

```bash
composer.phar require "kash/kash:*"
```

# Basic Usage

```php
<?php

// Configure the pool with a driver
$driver = new \Kash\Driver\ArrayDriver();
$pool   = new \Kash\CachePool($driver);

// Get an item base on a unique key. If the item does
// not exist, it creates one for you
/** @var \Kash\CacheItemInterface */
$item = $pool->getItem('example_key');

if (!$item->isHit()) {
    // ... do stuff, put results into $value
    $item->set($value);

    // Expires in 300 seconds from now
    $item->setExpiration(300);

    // Save the item to your cache
    $pool->save($item);
}

// $result is whatever you had it set to
$result = $item->get();

// Delete the item from the cache
$pool->deleteItems(array($item));

// Clear the backend cache of all items
$pool->clear();
```

# Core Concepts

## Items

Items are the smallest unit that can be cached. This would include the results
from an API call or possible just a simple value. Items are what you will use to
cache data and check expiration times.

## Pools

Items go into and come out of a pool. The pool uses Drivers to talk with various
Backends.

## Drivers

Drivers are used to communicate with cache Backends such as a filesytem,
database, etc. The only know of the Backend they need to communicate with and
that they are given CacheItem's to find and persist.

## Backends

Backends are anything that is used to store cached items. These include things
such as a filesystem up to Redis and everything in between.

# Drivers

## NullDriver

The `NullDriver` does not cache any data.

## ArrayDriver

This driver caches data in an `array`. It does not persist data, but you are
able to set values and expire items.

### Usage

```php
<?php

$driver = new \Kash\Driver\ArrayDriver();
$pool   = new \Kash\CachePool($driver);
```

## FilesystemDriver

Caches data to a filesystem.

## Creating Your Own Driver

All drivers MUST implement the [DriverInterface]. The documentation for what is
expected is documented in this file. Once you have your driver class created you
will just inject it into the CachePool when you create it. Easy! For some
examples please look at some of the included drivers code.

# API Documentation

API docs are generated using [phpDocumentor]. To generate documentation for
this project, please run:

```bash
phpdoc -d src -t build/api-docs
```

# Testing

[PHPUnit] is used as the testing framework. If you want to run tests, just run
`phpunit`.

```bash
phpunit
```

# Change Log

See [CHANGELOG.md]

# Contributing Guidelines

See [CONTRIBUTING.md]

# License [![Packagist](https://img.shields.io/packagist/l/kash/kash.svg)]()

Copyright (c) 2015 Joshua Estes

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.

[composer]: https://getcomposer.org/
[DriverInterface]: https://github.com/JoshuaEstes/Kash/blob/master/src/Kash/Driver/DriverInterface.php
[phpDocumentor]: http://www.phpdoc.org/
[PHPUnit]: https://phpunit.de/
[CHANGELOG.md]: https://github.com/JoshuaEstes/Kash/blob/master/CHANGELOG.md
[CONTRIBUTING.md]: https://github.com/JoshuaEstes/Kash/blob/master/CONTRIBUTING.md
