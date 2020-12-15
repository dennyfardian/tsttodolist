<?php

require_once "Google_FileCache.php";
require_once "Google_MemcacheCache.php";

/**
 * Abstract storage class

 */
abstract class Google_Cache {

  /**
   * Retrieves the data for the given key, or false if they
   * key is unknown or expired

   */
  abstract function get($key, $expiration = false);

  /**
   * Store the key => $value set. The $value is serialized
   * by this function so can be of any type

   */
  abstract function set($key, $value);

  /**
   * Removes the key/data pair for the given $key
   */
  abstract function delete($key);
}


