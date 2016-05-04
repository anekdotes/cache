<?php

/*
 * This file is part of the Cache package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Cache;

/**
 * Class storing the cache service in a file system.
 */
class FileCache implements CacheInterface
{
    /**
   * Directory containing the cache system.
   */
  public $directory;

  /**
   * Constructeur de la classe. Instancie le directory du caching.
   *
   * @param string $directory Path vers le réportoire du caching
   */
  public function __construct($directory)
  {
      $this->directory = $directory;
  }

  /**
   * Calculer la date d'expiration en additionant le temps présent et les minutes passées.
   *
   * @param  int $minutes Nombre de minutes avant l'expiration à calculer
   *
   * @return int          Date entière de la date calculée
   */
  public function expiration($minutes)
  {
      if ($minutes == 0) {
          return 9999999999;
      }

      return time() + ($minutes * 60);
  }

  /**
   * Generates the hashed path of the file that will be used for the key value.
   *
   * @param  string $key The key of the key-value pair used
   *
   * @return string      The path of the file for the key used
   */
  public function path($key)
  {
      $parts = array_slice(str_split($hash = md5($key), 2), 0, 2);

      return $this->directory.implode('/', $parts).'/'.$hash;
  }

  /**
   * Checks the expiration date for the provided key file.
   *
   * @param  string $key The key of the key-value pair used
   *
   * @return int         The integer expiration date (represented in second) of the key.
   */
  public function time($key)
  {
      $path = $this->path($key);

      if (!file_exists($path)) {
          return;
      }

      $stat = stat($path);

      return $stat['mtime'];
  }

  /**
   * Check if the Cached object has a file with the asked key in it.
   *
   * @param string $key The key of the object checked
   *
   * @return bool If the cached object exists
   */
  public function has($key)
  {
      $path = $this->path($key);

      if (!file_exists($path)) {
          return false;
      }

      try {
          $expire = substr($contents = file_get_contents($path), 0, 10);
      } catch (\Exception $e) {
          return false;
      }

      return strlen($contents) > 0;
  }

  /**
   * Obtained the cached object at the asked value.
   *
   * @param string $key The key of the object to get
   *
   * @return mixed The object fetched in the Cache
   */
  public function get($key)
  {
      $path = $this->path($key);

      if (!file_exists($path)) {
          return;
      }

      try {
          $expire = substr($contents = file_get_contents($path), 0, 10);
      } catch (\Exception $e) {
          return;
      }

      if (time() >= $expire) {
          $this->forget($expire);

          return;
      }

      return unserialize(substr($contents, 10));
  }

  /**
   * Sets a value to a cache key.
   *
   * @param string $key The key of the object to set
   * @param mixed $value The value of the object to set
   * @param int $minutes Expiration minutes
   */
  public function set($key, $value, $minutes)
  {
      $value = $this->expiration($key).serialize($value);
      try {
          $dirname = dirname($path = $this->path($key));
          if (!file_exists($dirname)) {
              mkdir($dirname, 0777, true);
          }
      } catch (\Exception $e) {
      }

      file_put_contents($path, $value);
  }

  /**
   * Sets a key-value pair without expiration.
   *
   * @param string $key the key to decrement
   * @param mixed $value the value of the saved object
   */
  public function forever($key, $value)
  {
      $this->put($key, $value, 0);
  }

  /**
   * Removes a key-value pair from the service.
   *
   * @param string $key the key to remove
   */
  public function forget($key)
  {
      $path = $this->path($key);

      if (file_exists($path)) {
          unlink($path);
      }

      return false;
  }

  /**
   * Removes all cached key-value pairs.
   */
  public function flush()
  {
      if (!is_dir($this->directory)) {
          return false;
      }

      $items = new FilesystemIterator($this->directory);

      foreach ($items as $item) {
          if ($item->isDir()) {
              rmdir($item->getPathname());
          } else {
              unlink($item->getPathname());
          }
      }
  }

  /**
   * Increments the value of a given key.
   *
   * @param string $key the key to increment
   * @param int $value my how much it's incremented
   */
  public function increment($key, $value = 1)
  {
      throw new \LogicException('Increment operations not supported by this driver.');
  }

  /**
   * Decrements the value of a given key.
   *
   * @param string $key the key to decrement
   * @param int $value by how much it's decremented
   */
  public function decrement($key, $value = 1)
  {
      throw new \LogicException('Decrement operations not supported by this driver.');
  }
}
