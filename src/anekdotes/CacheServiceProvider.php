<?php namespace Sitebase\Cache;

use Anekdotes\Meta\ServiceProvider;

/**
 * Sets up the Cache service, based on the configuration file provided in the app config files.
 */
class CacheServiceProvider extends ServiceProvider {

  /**
   * Registers the Cache service in the Application system.
   * @param  \Sitebase\Application\Application $app The Application that will use the Cache service
   * @throws \Exception If the driver specified in the config file is either not implemented or not specified.
   */
  public function register($app) {
    $driver = $app['config']->get('services.cache.driver', 'array');

    if ($driver === 'array') {
      $app['cache'] = new ArrayCache;
    } else if ($driver === 'file') {
      $app['cache'] = new FileCache;
    } else if ($driver === 'redis') {
      throw new \Exception('Redis cache driver not yet implemented!');
    } else {
      throw new \Exception('CacheServiceProvider couln\'t find the implementation for the specified driver');
    }

  }

}
