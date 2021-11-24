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
use PHPUnit\Framework\TestCase;

final class FileCacheTest extends TestCase
{
    private static $cache;

    public static function delTree($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }

    public static function setUpBeforeClass(): void
    {
        mkdir('tmp');

        self::$cache = new FileCache('tmp/');
    }

    public static function tearDownAfterClass(): void
    {
        self::delTree('tmp');
    }

    public function testExpiration()
    {
        $this->assertEquals(self::$cache->expiration(0), 9999999999);
        $this->assertEquals(self::$cache->expiration(5), time() + 300);
    }

    public function testPath()
    {
        $this->assertEquals(self::$cache->path('Test'), 'tmp/'.substr(md5('Test'), 0, 2).'/'.substr(md5('Test'), 2, 2).'/'.md5('Test'));
    }

    public function testTime()
    {
        //Test when file does not exist
        $this->assertEquals(self::$cache->time('Toaster'), '');

        //Standard function test
        self::$cache->set('Toaster', 'Test', 5);

        $this->assertEquals(self::$cache->time('Toaster'), time());
    }

    public function testHas()
    {
        //Test With non existing file
        $this->assertFalse(self::$cache->has('Potato'), 'Has does not return false on missing file.');

        //Test with expired date
        self::$cache->set('Toaster', 'Test', -5);

        $this->assertFalse(self::$cache->has('Toaster'), 'File not counted as expired by Has.');

        //Test with okay file
        self::$cache->set('Toaster', 'Test', 5);

        $this->assertTrue(self::$cache->has('Toaster'), 'Has did not take into acount that the file is there.');
    }

    public function testGets()
    {
        //Test With non existing file
        $this->assertEquals(self::$cache->get('Butternut'), '', 'Does not return false on missing file.');

        //Test with expired date
        self::$cache->set('Toaster', 'Test', -5);

        $this->assertEquals(self::$cache->get('Toaster'), '', 'File not counted as expired.');

        //Test with okay file
        self::$cache->set('Toaster', 'Test', 5);

        $this->assertEquals(self::$cache->get('Toaster'), 'Test', 'File has not been Get correctly.');
    }

    //Set does not need addtional tests as it's tested in has and get

    public function testForever()
    {
        self::$cache->set('Toaster', 'Test', -5);
        self::$cache->forever('Toaster', 'Toast');

        $this->assertEquals(self::$cache->get('Toaster'), 'Toast');
    }

    public function testForget()
    {
        self::$cache->forever('Toaster', 'Test');
        self::$cache->forget('Toaster');

        $this->assertFalse(self::$cache->has('Toaster'));
    }

    public function testFlush()
    {
        self::$cache->forever('Toaster', 'Test');
        self::$cache->forever('Tester', 'Test');
        self::$cache->flush();

        $this->assertFalse(self::$cache->has('Toaster'));
        $this->assertFalse(self::$cache->has('Tester'));

        //Test flush with a cache on a dir that does not exists
        $failFlushCache = new FileCache('rip');

        $this->assertFalse($failFlushCache->flush());
    }

    public function testIncrement()
    {
        $this->expectException(\LogicException::class);

        self::$cache->increment('Toaster');
    }

    public function testDecrement()
    {
        $this->expectException(\LogicException::class);
        
        self::$cache->decrement('Toaster');
    }
}
