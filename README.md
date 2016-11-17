# Anekdotes Cache

[![Latest Stable Version](https://poser.pugx.org/anekdotes/cache/v/stable)](https://packagist.org/packages/anekdotes/cache)
[![Build Status](https://travis-ci.org/anekdotes/cache.svg)](https://travis-ci.org/anekdotes/cache)
[![codecov.io](https://codecov.io/github/anekdotes/cache/coverage.svg?branch=master)](https://codecov.io/github/anekdotes/cache?branch=master)
[![StyleCI](https://styleci.io/repos/58052897/shield?style=flat)](https://styleci.io/repos/58052897)
[![License](https://poser.pugx.org/anekdotes/cache/license)](https://packagist.org/packages/anekdotes/cache)
[![Total Downloads](https://poser.pugx.org/anekdotes/cache/downloads)](https://packagist.org/packages/anekdotes/cache)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6d755b74e6fc466db5d7f8852abf0142)](https://www.codacy.com/app/steve-gagnev4si/cache?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=anekdotes/cache&amp;utm_campaign=Badge_Grade)

Allows caching using different drivers

## Installation

Install via composer into your project:

    composer require anekdotes/cache

## Usage

Declare your Cache object depending on your Driver. After construction, all Cache objects can be manipulated the same way.

```php
use Anekdotes\Cache\FileCache;
$path = 'tmp/cache/'; //The slash at the end is IMPORTANT. MAKE SURE YOU HAVE IT!
$cache = new FileCache($path);
$key = 'Toaster';
$value = 'Test';
$minutes = 5;
$cache->set($key, $value, $minutes);
$cache->get('Toaster'); //Returns 'Test' as long as this call is made in a 5 minute time-frame past the previous set call.
$cache->time('Toaster'); //Return the datetime object of when this key has been set
$cache->forget('Toaster');
$cache->has('Toaster'); //Returns false.
```

## Notes

* The ArrayCache driver does not currently analyze expiration time. This means all array cached objects last forever.

* The FileCache driver does not implement the increment and decrement functions. Both functions throw LogicException under this driver.

* Setting a cache's expiration to zero will make it never expire. Using ```$cache->forever()````does the same thing.

* You can use ```$cache->flush()``` to remove all data in the cache.
