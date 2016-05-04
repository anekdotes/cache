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
}
