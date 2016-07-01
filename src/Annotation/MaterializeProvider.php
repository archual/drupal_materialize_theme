<?php
/**
 * @file
 * Contains \Drupal\materialize\Annotation\MaterializeProvider.
 */

namespace Drupal\materialize\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a MaterializeProvider annotation object.
 *
 * Plugin Namespace: "Plugin/Provider".
 *
 * @see \Drupal\materialize\Plugin\ProviderInterface
 * @see \Drupal\materialize\Plugin\ProviderManager
 * @see \Drupal\materialize\Theme::getProviders()
 * @see \Drupal\materialize\Theme::getProvider()
 * @see plugin_api
 *
 * @Annotation
 */
class MaterializeProvider extends Plugin {

  /**
   * An API URL used to retrieve data for the provider.
   *
   * @var string
   */
  protected $api = '';

  /**
   * An array of CSS assets.
   *
   * @var array
   */
  protected $css = [];

  /**
   * A description about the provider.
   *
   * @var string
   */
  protected $description = '';

  /**
   * A flag determining whether or not the API request has failed.
   *
   * @var bool
   */
  protected $error = FALSE;

  /**
   * A flag determining whether or not data has been manually imported.
   *
   * @var bool
   */
  protected $imported = FALSE;

  /**
   * An array of JavaScript assets.
   *
   * @var array
   */
  protected $js = [];

  /**
   * A human-readable label.
   *
   * @var string
   */
  protected $label = '';

  /**
   * An associative array of minified CSS and JavaScript assets.
   *
   * @var array
   */
  protected $min = ['css' => [], 'js' => []];

  /**
   * An array of themes supported by the provider.
   *
   * @var array
   */
  protected $themes = [];

  /**
   * An array of versions supported by the provider.
   *
   * @var array
   */
  protected $versions = [];

}
