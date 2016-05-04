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
 * Class storing the cache service in an array.
 */
class ArrayCache implements CacheInterface
{
    /**
   * Array containing the cached key-value pairs.
   */
  protected $storage = [];

  /**
   * Check if the Cached object has an object with the asked key in it.
   *
   * @param string $key The key of the object checked
   *
   * @return bool If the cached object exists
   */
  public function has($key)
  {
      return array_key_exists($key, $this->storage);
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
      if (array_key_exists($key, $this->storage)) {
          return $this->storage[$key];
      }
  }

  /**
   * Sets a value to a cache key-value pair.
   *
   * @param string $key The key of the object to set
   * @param mixed $value The value of the object to set
   * @param int $minutes Expiration minutes
   */
  public function set($key, $value, $minutes)
  {
      $this->storage[$key] = $value;
  }

  /**
   * Increments the value of a given key. Only works for integer values.
   *
   * @param string $key the key to increment
   * @param int $value my how much it's incremented
   */
  public function increment($key, $value = 1)
  {
      $this->storage[$key] = $this->storage[$key] + $value;

      return $this->storage[$key];
  }

  /**
   * Decrements the value of a given key.
   *
   * @param string $key the key to decrement
   * @param int $value my how much it's decremented
   */
  public function decrement($key, $value = 1)
  {
      $this->storage[$key] = $this->storage[$key] - $value;

      return $this->storage[$key];
  }

  /**
   * Sets a key-value pair without expiration.
   *
   * @param string $key the key to decrement
   * @param mixed $value the value of the saved object
   */
  public function forever($key, $value)
  {
      $this->set($key, $value);
  }

  /**
   * Removes a key-value pair from the service.
   *
   * @param string $key the key to remove
   */
  public function forget($key)
  {
      unset($this->storage[$key]);
  }

  /**
   * Removes all cached key-value pairs.
   */
  public function flush()
  {
      $this->storage = [];
  }
}
