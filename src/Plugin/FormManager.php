<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\FormManager.
 */

namespace Drupal\materialize\Plugin;

use Drupal\materialize\Theme;

/**
 * Manages discovery and instantiation of Materialize form alters.
 */
class FormManager extends PluginManager {

  /**
   * Constructs a new \Drupal\materialize\Plugin\FormManager object.
   *
   * @param \Drupal\materialize\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Form', 'Drupal\materialize\Plugin\Form\FormInterface', 'Drupal\materialize\Annotation\MaterializeForm');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':form', $this->getCacheTags());
  }

}
