<?php


require_once "Google_P12Signer.php";

/**
 * Signs data.
 */
abstract class Google_Signer {
  /**
   * Signs data, returns the signature as binary data.
   */
  abstract public function sign($data);
}
