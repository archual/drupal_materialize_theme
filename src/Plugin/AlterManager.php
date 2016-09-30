<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\AlterManager.
 */

namespace Drupal\materialize\Plugin;

use Drupal\materialize\Theme;

/**
 * Manages discovery and instantiation of Materialize hook alters.
 */
class AlterManager extends PluginManager {

  /**
   * Constructs a new \Drupal\materialize\Plugin\AlterManager object.
   *
   * @param \Drupal\materialize\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Alter', 'Drupal\materialize\Plugin\Alter\AlterInterface', 'Drupal\materialize\Annotation\MaterializeAlter');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':alter', $this->getCacheTags());
  }

}
