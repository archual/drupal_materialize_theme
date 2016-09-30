<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\PrerenderManager.
 */

namespace Drupal\materialize\Plugin;

use Drupal\materialize\Theme;
use Drupal\materialize\Utility\Element;

/**
 * Manages discovery and instantiation of Materialize pre-render callbacks.
 */
class PrerenderManager extends PluginManager {

  /**
   * Constructs a new \Drupal\materialize\Plugin\PrerenderManager object.
   *
   * @param \Drupal\materialize\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Prerender', 'Drupal\materialize\Plugin\Prerender\PrerenderInterface', 'Drupal\materialize\Annotation\MaterializePrerender');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':prerender', $this->getCacheTags());
  }

  /**
   * Pre-render render array element callback.
   *
   * @param array $element
   *   The render array element.
   *
   * @return array
   *   The modified render array element.
   */
  public static function preRender(array $element) {
    if (!empty($element['#materialize_ignore_pre_render'])) {
      return $element;
    }

    $e = Element::create($element);

    if ($e->isType('machine_name')) {
      $e->addClass('form-inline', 'wrapper_attributes');
    }

    // Add smart descriptions to the element, if necessary.
    $e->smartDescription();

    return $element;
  }

}
