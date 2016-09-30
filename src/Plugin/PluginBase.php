<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\PluginBase.
 */

namespace Drupal\materialize\Plugin;

use Drupal\materialize\Materialize;

/**
 * Base class for an update.
 */
class PluginBase extends \Drupal\Core\Plugin\PluginBase {

  /**
   * The currently set theme object.
   *
   * @var \Drupal\materialize\Theme
   */
  protected $theme;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    if (!isset($configuration['theme'])) {
      $configuration['theme'] = Materialize::getTheme();
    }
    $this->theme = $configuration['theme'];
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

}
