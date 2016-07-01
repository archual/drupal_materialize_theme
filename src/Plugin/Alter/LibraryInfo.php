<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Alter\LibraryInfo.
 */

namespace Drupal\materialize\Plugin\Alter;

use Drupal\materialize\Annotation\MaterializeAlter;
use Drupal\materialize\Materialize;
use Drupal\materialize\Plugin\PluginBase;
use Drupal\Component\Utility\NestedArray;

/**
 * Implements hook_library_info_alter().
 *
 * @MaterializeAlter("library_info")
 */
class LibraryInfo extends PluginBase implements AlterInterface {

  /**
   * {@inheritdoc}
   */
  public function alter(&$libraries, &$extension = NULL, &$context2 = NULL) {
    if ($extension === 'materialize') {
//      // Retrieve the theme's CDN provider and assets.
//      $provider = $this->theme->getProvider();
//      $assets = $provider ? $provider->getAssets() : [];
//
//      // Immediately return if there is no provider or assets.
//      if (!$provider || !$assets) {
//        return;
//      }
//
//      // Merge the assets into the library info.
//      $libraries['theme'] = NestedArray::mergeDeepArray([$assets, $libraries['theme']], TRUE);
//
//      // Add a specific version and theme CSS overrides file.
//      // @todo This should be retrieved by the Provider API.
//      $version = $this->theme->getSetting('cdn_' . $provider->getPluginId() . '_version') ?: Materialize::FRAMEWORK_VERSION;
//      $libraries['theme']['version'] = $version;
//      $provider_theme = $this->theme->getSetting('cdn_' . $provider->getPluginId() . '_theme') ?: 'materialize';
//      $provider_theme = $provider_theme === 'materialize' || $provider_theme === 'materialize_theme' ? '' : "-$provider_theme";
//
//      foreach ($this->theme->getAncestry(TRUE) as $ancestor) {
//        $overrides = $ancestor->getPath() . "/css/$version/overrides$provider_theme.min.css";
//        if (file_exists($overrides)) {
//          // Since this uses a relative path to the ancestor from DRUPAL_ROOT,
//          // we must prefix the entire path with / so it doesn't append the
//          // active theme's path (which would duplicate the prefix).
//          $libraries['theme']['css']['theme']["/$overrides"] = [];
//          break;
//        }
//      }
    }
    // Core replacements.
    elseif ($extension === 'core') {
      // Replace core dialog/jQuery UI implementations with Materialize Modals.
//      if ($this->theme->getSetting('modal_enabled')) {
//        $libraries['drupal.dialog']['override'] = 'materialize/drupal.dialog';
//        $libraries['drupal.dialog.ajax']['override'] = 'materialize/drupal.dialog.ajax';
//      }
    }
  }

}
