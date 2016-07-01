<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Preprocess\PreprocessInterface.
 */

namespace Drupal\materialize\Plugin\Preprocess;

/**
 * Defines the interface for an object oriented preprocess plugin.
 */
interface PreprocessInterface {

  /**
   * Preprocess theme hook variables.
   *
   * @param array $variables
   *   The variables array, passed by reference (modify in place).
   * @param string $hook
   *   The name of the theme hook.
   * @param array $info
   *   The theme hook info array.
   */
  public function preprocess(array &$variables, $hook, array $info);

}
