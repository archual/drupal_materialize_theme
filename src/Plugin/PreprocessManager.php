<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\PreprocessManager.
 */

namespace Drupal\materialize\Plugin;

use Drupal\materialize\Theme;

/**
 * Manages discovery and instantiation of Materialize preprocess hooks.
 */
class PreprocessManager extends PluginManager {

  /**
   * Constructs a new \Drupal\materialize\Plugin\PreprocessManager object.
   *
   * @param \Drupal\materialize\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Preprocess', 'Drupal\materialize\Plugin\Preprocess\PreprocessInterface', 'Drupal\materialize\Annotation\MaterializePreprocess');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':preprocess', $this->getCacheTags());
  }

}
