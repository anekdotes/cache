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

use Anekdotes\Cache\FileCache;
use PHPUnit_Framework_TestCase;

class FileCacheTest extends PHPUnit_Framework_TestCase
{
    public static function delTree($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }

    protected function tearDown()
    {
        self::delTree('tmp');
    }

    protected function setUp()
    {
        mkdir('tmp');
        $this->cache = new FileCache('tmp/');
    }

    public function testExpiration()
    {
        $this->assertEquals($this->cache->expiration(0), 9999999999);
        $this->assertEquals($this->cache->expiration(5), time() + 300);
    }

    public function testPath()
    {
        $this->assertEquals($this->cache->path('Test'), 'tmp/'.substr(md5('Test'), 0, 2).'/'.substr(md5('Test'), 2, 2).'/'.md5('Test'));
    }

    public function testTime()
    {
        $this->cache->set('Toaster', 'Test', 5);
        $this->assertEquals($this->cache->time('Toaster'), time());
    }

    public function testHas()
    {
        //Test With non existing file
        $this->assertFalse($this->cache->has('Toaster'), 'Has does not return false on missing file.');
        //Test with expired date
        $this->cache->set('Toaster', 'Test', -5);
        $this->assertFalse($this->cache->has('Toaster'), 'File not counted as expired by Has.');
        //Test with okay file
        $this->cache->set('Toaster', 'Test', 5);
        $this->assertTrue($this->cache->has('Toaster'), 'Has did not take into acount that the file is there.');
    }

    public function testGets()
    {
        //Test With non existing file
        $this->assertEquals($this->cache->get('Toaster'), '', 'Does not return false on missing file.');
        //Test with expired date
        $this->cache->set('Toaster', 'Test', -5);
        $this->assertEquals($this->cache->get('Toaster'), '', 'File not counted as expired.');
        //Test with okay file
        $this->cache->set('Toaster', 'Test', 5);
        $this->assertEquals($this->cache->get('Toaster'), 'Test', 'File has not been Get correctly.');
    }

    //Set does not need addtional tests as it's tested in has and get

    public function testForever()
    {
        $this->cache->set('Toaster', 'Test', -5);
        $this->cache->forever('Toaster', 'Toast');
        $this->assertEquals($this->cache->get('Toaster'), 'Toast');
    }

    public function testForget()
    {
        $this->cache->forever('Toaster', 'Test');
        $this->cache->forget('Toaster');
        $this->assertFalse($this->cache->has('Toaster'));
    }

    public function testFlush()
    {
        $this->cache->forever('Toaster', 'Test');
        $this->cache->forever('Tester', 'Test');
        $this->cache->flush();
        $this->assertFalse($this->cache->has('Toaster'));
        $this->assertFalse($this->cache->has('Tester'));
    }

    public function testIncrement()
    {
        $this->expectException(\LogicException::class);
        $this->cache->increment('Toaster');
    }

    public function testDecrement()
    {
        $this->expectException(\LogicException::class);
        $this->cache->decrement('Toaster');
    }
}
