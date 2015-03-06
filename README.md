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

# Framework Integration

# License

MIT
