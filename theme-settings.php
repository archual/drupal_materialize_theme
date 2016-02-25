<?php
/**
 * @file
 * theme-settings.php
 *
 * Provides theme settings for Materialize based themes.
 *
 * @see ./includes/settings.inc
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implementation of hook_form_system_theme_settings_alter()
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 *
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function materialize_form_system_theme_settings_alter(&$form, FormStateInterface &$form_state) {
  // Do not add Bootstrap specific settings to non-bootstrap based themes.
  $args = $form_state->getBuildInfo()['args'];
  $theme = !empty($args[0]) ? $args[0] : FALSE;
  if (isset($form_id) || $theme === FALSE) {
    return;
  }

  $form['materialize'] = array(
    '#type' => 'vertical_tabs',
    '#prefix' => '<h2><small>' . t('Materialize Settings') . '</small></h2>',
    '#weight' => -10,
  );

  // General.
  $form['general'] = array(
    '#type' => 'details',
    '#title' => t('General'),
    '#group' => 'materialize',
  );

  // Components.
  $form['components'] = array(
    '#type' => 'details',
    '#title' => t('Components'),
    '#group' => 'materialize',
  );

  // Breadcrumbs.
  $form['components']['breadcrumb'] = array(
    '#type' => 'details',
    '#title' => t('Breadcrumbs'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['components']['breadcrumb']['breadcrumbs'] = array(
    '#type' => 'select',
    '#title' => t('Breadcrumbs visibility'),
    '#default_value' => theme_get_setting('breadcrumbs', $theme),
    '#options' => array(
      0 => t('Hidden'),
      1 => t('Visible'),
    ),
  );
  $form['components']['breadcrumb']['breadcrumbs_home'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show "Home" breadcrumbs link'),
    '#default_value' => theme_get_setting('breadcrumbs_home', $theme),
    '#description' => t('If your site has a module dedicated to handling breadcrumbs already, ensure this setting is enabled.'),
    '#states' => array(
      'invisible' => array(
        ':input[name="breadcrumbs"]' => array('value' => 0),
      ),
    ),
  );
  $form['components']['breadcrumb']['breadcrumbs_title'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show current page title at end'),
    '#default_value' => theme_get_setting('breadcrumbs_title', $theme),
    '#description' => t('If your site has a module dedicated to handling breadcrumbs already, ensure this setting is disabled.'),
    '#states' => array(
      'invisible' => array(
        ':input[name="breadcrumbs"]' => array('value' => 0),
      ),
    ),
  );

  // Navbar.
  $form['components']['navbar_position'] = array(
    '#type' => 'details',
    '#title' => t('Navbar position'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['components']['navbar_position']['fixed_header'] = array(
    '#type' => 'checkbox',
    '#title' => t('Fixed header in top'),
    '#default_value' => theme_get_setting('fixed_header', $theme),
  );

  // Layouts.
  $form['layouts'] = array(
    '#type' => 'details',
    '#title' => t('Layouts'),
    '#group' => 'materialize',
  );
}