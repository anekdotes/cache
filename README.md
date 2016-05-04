# Anekdotes Cache

[![Latest Stable Version](https://poser.pugx.org/anekdotes/cache/v/stable)](https://packagist.org/packages/anekdotes/cache)
[![Build Status](https://travis-ci.org/anekdotes/cache.svg)](https://travis-ci.org/anekdotes/cache)
[![codecov.io](https://codecov.io/github/anekdotes/cache/coverage.svg?branch=master)](https://codecov.io/github/anekdotes/cache?branch=master)
[![StyleCI](https://styleci.io/repos/58052897/shield?style=flat)](https://styleci.io/repos/58052897)
[![License](https://poser.pugx.org/anekdotes/cache/license)](https://packagist.org/packages/anekdotes/cache)
[![Total Downloads](https://poser.pugx.org/anekdotes/cache/downloads)](https://packagist.org/packages/anekdotes/cache)

Allows caching using different drivers

## Installation

Install via composer into your project:

    composer require anekdotes/cache

## Usage

Declare your Cache object depending on your Driver. After construction, all Cache objects can be manipulated the same way.

    use Anekdotes\Cache\FileCache;
    $path = 'tmp/cache';
    $cache = new FileCache($path);
    $key = 'Toaster';
    $value = 'Test';
    $minutes = 5;
    $cache->set($key, $value, $minutes);
    $cache->get('Toaster'); //Returns 'Test' if executed before 5 minutes after previous call. Otherwise returns ''
    $cache->forget('Toaster');
    $cache->has('Toaster'); //Currently returns false. Would have returned true if we didn't use forget and we were still in the 5 minutes range.

## Notes

* The ArrayCache driver does not analyze expiration time. This means all array cached objects last forever.

* The FileCache driver does not implement the increment and decrement functions. Both functions throw LogicException under this driver.
