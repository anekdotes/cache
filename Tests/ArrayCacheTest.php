<?php

/*
 * This file is part of the Cache package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Anekdotes\Cache\ArrayCache;
use PHPUnit_Framework_TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class ArrayCacheTest extends PHPUnit_Framework_TestCase
{
    public function testGetSet()
    {
        $cache = new ArrayCache();
        $cache->set('Toaster', 'Toast', 3);
        $this->assertEquals($cache->get('Toaster'), 'Toast');
    }

    public function testHas()
    {
        $cache = new ArrayCache();
        $cache->set('Toaster', 'Toast', 3);
        $this->assertTrue($cache->has('Toaster'));
        $this->assertFalse($cache->has('Toast'));
    }

    public function testIncrement()
    {
        $cache = new ArrayCache();
        $cache->set('Toaster', 3, 3);
        $cache->increment('Toaster');
        $this->assertEquals($cache->get('Toaster'), 4);
        $cache->set('Test', 5, 3);
        $cache->increment('Test', 3);
        $this->assertEquals($cache->get('Test'), 8);
    }

    public function testDecrement()
    {
        $cache = new ArrayCache();
        $cache->set('Toaster', 3, 3);
        $cache->decrement('Toaster');
        $this->assertEquals($cache->get('Toaster'), 2);
        $cache->set('Test', 5, 3);
        $cache->decrement('Test', 3);
        $this->assertEquals($cache->get('Test'), 2);
    }

    public function testForever()
    {
        $cache = new ArrayCache();
        $cache->forever('Toaster', 'Toast');
        $this->assertEquals($cache->get('Toaster'), 'Toast');
    }

    public function testForget()
    {
        $cache = new ArrayCache();
        $cache->set('Toaster', 'Toast', 3);
        $cache->forget('Toaster');
        $this->assertFalse($cache->has('Toaster'));
    }

    public function testFlush()
    {
        $cache = new ArrayCache();
        $cache->set('Toaster', 'Toast', 3);
        $cache->flush();
        $this->assertFalse($cache->has('Toaster'));
    }
}
