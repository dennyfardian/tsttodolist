<?php

class Google_MemcacheCache extends Google_Cache {
  private $connection = false;

  public function __construct() {
    global $apiConfig;
    if (! function_exists('memcache_connect')) {
      throw new Google_CacheException("Memcache functions not available");
    }
    $this->host = $apiConfig['ioMemCacheCache_host'];
    $this->port = $apiConfig['ioMemCacheCache_port'];
    if (empty($this->host) || empty($this->port)) {
      throw new Google_CacheException("You need to supply a valid memcache host and port");
    }
  }

  private function isLocked($key) {
    $this->check();
    if ((@memcache_get($this->connection, $key . '.lock')) === false) {
      return false;
    }
    return true;
  }

  private function createLock($key) {
    $this->check();
    @memcache_add($this->connection, $key . '.lock', '', 0, 5);
  }

  private function removeLock($key) {
    $this->check();
    // suppress all warnings, if some other process removed it that's ok too
    @memcache_delete($this->connection, $key . '.lock');
  }

  private function waitForLock($key) {
    $this->check();
    $tries = 20;
    $cnt = 0;
    do {
      usleep(250);
      $cnt ++;
    } while ($cnt <= $tries && $this->isLocked($key));
    if ($this->isLocked($key)) {
      // 5 seconds passed
      $this->removeLock($key);
    }
  }

  private function connect() {
    if (! $this->connection = @memcache_pconnect($this->host, $this->port)) {
      throw new Google_CacheException("Couldn't connect to memcache server");
    }
  }

  private function check() {
    if (! $this->connection) {
      $this->connect();
    }
  }

  /**
   * @inheritDoc
   */
  public function get($key, $expiration = false) {
    $this->check();
    if (($ret = @memcache_get($this->connection, $key)) === false) {
      return false;
    }
    if (! $expiration || (time() - $ret['time'] > $expiration)) {
      $this->delete($key);
      return false;
    }
    return $ret['data'];
  }

  /**
   * @inheritDoc
   * @param string $key
   * @param string $value
   * @throws Google_CacheException
   */
  public function set($key, $value) {
    $this->check();
    if (@memcache_set($this->connection, $key, array('time' => time(),
        'data' => $value), false) == false) {
      throw new Google_CacheException("Couldn't store data in cache");
    }
  }

  /**
   */
  public function delete($key) {
    $this->check();
    @memcache_delete($this->connection, $key);
  }
}
