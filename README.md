Kash/Kash
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

# Basic Usage

```php
<?php

use Kash\Driver\ArrayDriver;
use Kash\CachePool;

$driver = new ArrayDriver();
$pool   = new CachePool($driver);

$item = $pool->getItem('example_key');

if (!$item->isHit()) {
    // ... do stuff, put result into $value
    $pool->save($item->set($value));
}

$result = $item->get();
```

# Core Concepts

## Items

Items are the smallest unit that can be cached. This would include the results
from an API call or possible just a simple value.

## Pools

Items go into and come out of a pool.

## Drivers

Drivers are the classes that will persist an Item to some type of storage. For
example the FilesystemDriver will save an Item to the filesystem once
configured.

# Usage

This section will give more detailed examples of using the library.

```php
```

# Drivers

## NullDriver

The `NullDriver` does not cache any data.

## ArrayDriver

This driver caches data in an `array`. It does not persist data, but you are
able to set values and expire items.

## FilesystemDriver

Caches data to a filesystem.

# Change Log

See [CHANGELOG.md]

# Contributing Guidelines

See [CONTRIBUTING.md]

# License

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

[CHANGELOG.md]: https://github.com/JoshuaEstes/Kash/blob/master/CHANGELOG.md
[CONTRIBUTING.md]: https://github.com/JoshuaEstes/Kash/blob/master/CONTRIBUTING.md
