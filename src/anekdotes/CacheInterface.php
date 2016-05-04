<?php namespace Sitebase\Cache;

/**
 * Interface used to create different kind of caching services
 */
interface CacheInterface {

  /**
   * Check if the Cached object has an object with the asked key in it.
   * @param string $key The key of the object checked
   * @return boolean If the cached object exists
   */
  public function has($key);
  /**
   * Obtained the cached object at the asked value
   * @param string $key The key of the object to get
   * @return mixed The object fetched in the Cache
   */
  public function get($key);
  /**
   * Sets a value to a cache key
   * @param string $key The key of the object to set
   * @param mixed $value The value of the object to set
   * @param int $minutes Expiration minutes
   */
  public function set($key, $value, $minutes);
  /**
   * Increments the value of a given key
   * @param string $key the key to increment
   * @param int $value my how much it's incremented
   */
  public function increment($key, $value = 1);
  /**
   * Decrements the value of a given key
   * @param string $key the key to decrement
   * @param int $value by how much it's decremented
   */
  public function decrement($key, $value = 1);
  /**
   * Sets a key-value pair without expiration
   * @param string $key the key to decrement
   * @param mixed $value the value of the saved object
   */
  public function forever($key, $value);
  /**
   * Removes a key-value pair from the service
   * @param string $key the key to remove
   */
  public function forget($key);
  /**
   * Removes all cached key-value pairs
   */
  public function flush();

}
