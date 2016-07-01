<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Preprocess\Page.
 */

namespace Drupal\materialize\Plugin\Preprocess;

use Drupal\Core\Template\Attribute;
use Drupal\materialize\Annotation\MaterializePreprocess;
use Drupal\materialize\Utility\DrupalAttributes;
use Drupal\materialize\Utility\Variables;

/**
 * Pre-processes variables for the "page" theme hook.
 *
 * @ingroup theme_preprocess
 *
 * @MaterializePreprocess("page")
 */
class Page extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocessVariables(Variables $variables, $hook, array $info) {
    // Add information about the number of sidebars.
    $variables['content_column_attributes'] = new Attribute();
    $variables['content_column_attributes']['class'] = array();

    if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
      $variables['content_column_attributes']['class'][] = 'col-s6';
    }
    elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
      $variables['content_column_attributes']['class'][] = 'col-s9';
    }
    else {
      $variables['content_column_attributes']['class'][] = 'col-s12';
    }

    // Settings for fixed navbar.
    if ( theme_get_setting('fixed_header') === 1) {
      $variables['navbar_attributes'] = new Attribute();
      $variables['navbar_attributes']['class'] = array('navbar-fixed');
    }

    // Logo.
    $url = Url::fromRoute('<front>');
    $link_options = array(
      'attributes' => array(
        'class' => array(
          'brand-logo'
        ),
      ),
    );

    $url->setOptions($link_options);
    $variables['logo'] = \Drupal::l(t('Logo'), $url);

    // User nav.
    // User page.
    $url = Url::fromRoute('user.page');
    $variables['user_page'] = \Drupal::l(t('<i class="small left material-icons">perm_identity</i>' . 'Account'), $url);

    // Log in/log out.
    // @TODO Change on system menu user link (log in/log out).
    $url = Url::fromRoute('user.logout');
    $variables['user_logout'] = \Drupal::l(t('<i class="small left material-icons">open_in_new</i>' . 'Log out'), $url);

    // Setup default attributes.
    $variables->getAttributes(DrupalAttributes::NAVBAR);
    $variables->getAttributes(DrupalAttributes::HEADER);
    $variables->getAttributes(DrupalAttributes::CONTENT);
    $variables->getAttributes(DrupalAttributes::FOOTER);
    $this->preprocessAttributes($variables, $hook, $info);
  }

}
