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
//  if (isset($form_id) || $theme === FALSE || !in_array('bootstrap', _bootstrap_get_base_themes($theme, TRUE))) {
  if (isset($form_id) || $theme === FALSE) {
    return;
  }

  $form['materialize'] = array(
    '#type' => 'vertical_tabs',
//    '#attached' => array(
//      'library'  => array('bootstrap/adminscript'),
//    ),
    '#prefix' => '<h2><small>' . t('Materialize Settings') . '</small></h2>',
    '#weight' => -10,
  );

  // General.
  $form['general'] = array(
    '#type' => 'details',
    '#title' => t('General'),
    '#group' => 'materialize',
  );

  // @TODO Add prefix for theme settings.
//  function bootstrap_setting($name, $theme = NULL, $prefix = 'bootstrap') {
//    $prefix = !empty($prefix) ? $prefix . '_' : '';
//    $setting = theme_get_setting($prefix . $name, $theme);
//    return $setting;
//  }

  $form['general']['navbar_position'] = array(
    '#type' => 'checkbox',
    '#title' => t('Navbar position'),
    '#default_value' => theme_get_setting('navbar_position', $theme),
    '#description' => t('Fixed header in top'),
  );

  // Layouts.
  $form['layouts'] = array(
    '#type' => 'details',
    '#title' => t('Layouts'),
    '#group' => 'materialize',
  );
}