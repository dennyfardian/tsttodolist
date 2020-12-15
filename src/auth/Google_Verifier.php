<?php


require_once "Google_PemVerifier.php";

/**
 * Verifies signatures.
 */
abstract class Google_Verifier {
  /**
   * Checks a signature, returns true if the signature is correct,
   * false otherwise.
   */
  abstract public function verify($data, $signature);
}
