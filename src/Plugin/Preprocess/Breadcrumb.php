<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Preprocess\Breadcrumb.
 */

namespace Drupal\materialize\Plugin\Preprocess;

use Drupal\materialize\Annotation\BootstrapPreprocess;
use Drupal\Core\Template\Attribute;

/**
 * Pre-processes variables for the "breadcrumb" theme hook.
 *
 * @ingroup theme_preprocess
 *
 * @BootstrapPreprocess("breadcrumb")
 */
class Breadcrumb extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook, array $info) {
    $breadcrumb = &$variables['breadcrumb'];

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('breadcrumbs_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    if (theme_get_setting('breadcrumbs_title') && !empty($breadcrumb)) {
      $request = \Drupal::request();
      $route_match = \Drupal::routeMatch();
      $page_title = \Drupal::service('title_resolver')
        ->getTitle($request, $route_match->getRouteObject());

      if (!empty($page_title)) {
        $breadcrumb[] = array(
          'text' => $page_title,
          'attributes' => new Attribute(['class' => ['active']]),
        );
      }
    }
  }
}
