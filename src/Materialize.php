<?php
/**
 * @file
 * Contains \Drupal\materialize\Materialize.
 */

namespace Drupal\materialize;

use Drupal\materialize\Plugin\AlterManager;
use Drupal\materialize\Plugin\FormManager;
use Drupal\materialize\Plugin\PreprocessManager;
use Drupal\materialize\Utility\Unicode;
use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Extension\ThemeHandlerInterface;

/**
 * The primary class for the Drupal Materialize base theme.
 *
 * Provides many helper methods.
 */
class Materialize {
  /**
   * Tag used to invalidate caches.
   *
   * @var string
   */
  const CACHE_TAG = 'theme_registry';

  /**
   * Retrieves a theme instance of \Drupal\materialize.
   *
   * @param string $name
   *   The machine name of a theme. If omitted, the active theme will be used.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler object.
   *
   * @return \Drupal\materialize\Theme
   *   A theme object.
   */
  public static function getTheme($name = NULL, ThemeHandlerInterface $theme_handler = NULL) {
    // Immediately return if theme passed is already instantiated.
    if ($name instanceof Theme) {
      return $name;
    }

    static $themes = [];
    static $active_theme;
    if (!isset($active_theme)) {
      $active_theme = \Drupal::theme()->getActiveTheme()->getName();
    }
    if (!isset($name)) {
      $name = $active_theme;
    }

    if (!isset($theme_handler)) {
      $theme_handler = self::getThemeHandler();
    }

    if (!isset($themes[$name])) {
      $themes[$name] = new Theme($theme_handler->getTheme($name), $theme_handler);
    }

    return $themes[$name];
  }

  /**
   * Retrieves the theme handler instance.
   *
   * @return \Drupal\Core\Extension\ThemeHandlerInterface
   *   The theme handler instance.
   */
  public static function getThemeHandler() {
    static $theme_handler;
    if (!isset($theme_handler)) {
      $theme_handler = \Drupal::service('theme_handler');
    }
    return $theme_handler;
  }

  /**
   * Returns the theme hook definition information.
   *
   * This base-theme's custom theme hook implementations. Never define "path"
   * as this is automatically detected and added.
   *
   * @see \Drupal\meterialize\Plugin\Alter\ThemeRegistry::alter()
   * @see meterialize_theme_registry_alter()
   * @see meterialize_theme()
   * @see hook_theme()
   */
  public static function getThemeHooks() {
    $hooks = array();
    return $hooks;
  }
  
  /**
   * Adds a callback to an array.
   *
   * @param array $callbacks
   *   An array of callbacks to add the callback to, passed by reference.
   * @param array|string $callback
   *   The callback to add.
   * @param array|string $replace
   *   If specified, the callback will instead replace the specified value
   *   instead of being appended to the $callbacks array.
   * @param int $action
   *   Flag that determines how to add the callback to the array.
   *
   * @return bool
   *   TRUE if the callback was added, FALSE if $replace was specified but its
   *   callback could be found in the list of callbacks.
   */
  public static function addCallback(array &$callbacks, $callback, $replace = NULL, $action = Materialize::CALLBACK_APPEND) {
    // Replace a callback.
    if ($replace) {
      // Iterate through the callbacks.
      foreach ($callbacks as $key => $value) {
        // Convert each callback and match the string values.
        if (Unicode::convertCallback($value) === Unicode::convertCallback($replace)) {
          $callbacks[$key] = $callback;
          return TRUE;
        }
      }
      // No match found and action shouldn't append or prepend.
      if ($action !== self::CALLBACK_REPLACE_APPEND || $action !== self::CALLBACK_REPLACE_PREPEND) {
        return FALSE;
      }
    }

    // Append or prepend the callback.
    switch ($action) {
      case self::CALLBACK_APPEND:
      case self::CALLBACK_REPLACE_APPEND:
        $callbacks[] = $callback;
        return TRUE;

      case self::CALLBACK_PREPEND:
      case self::CALLBACK_REPLACE_PREPEND:
        array_unshift($callbacks, $callback);
        return TRUE;

      default:
        return FALSE;
    }
  }

  /**
   * Returns a specific Material Icons font.
   *
   * @param string $name
   *   The icon name.
   *
   * @return array
   *   The render containing the icon defined by $name, $default value if
   *   icon does not exist or returns NULL if no icon could be rendered.
   */
  public static function material_icons_font($name) {
    $icon = [];

    // Ensure the icon specified is a valid Material Icons .
    if (in_array($name, self::material_icons())) {
      $icon = [
        '#type' => 'html_tag',
        '#tag' => 'i',
        '#value' => $name,
        '#attributes' => [
          'class' => ['material-icons'],
          'aria-hidden' => 'true',
        ],
      ];
    }

    return $icon;
  }

  /**
   * Provides additional variables to be used in elements and templates.
   *
   * @return array
   *   An associative array containing key/default value pairs.
   */
  public static function extraVariables() {
    return [
      // @see https://drupal.org/node/2035055
      'context' => [],

      // @see https://drupal.org/node/2219965
      'icon' => NULL,
      'icon_position' => 'before',
      'icon_only' => FALSE,
    ];
  }

  /**
   * Initializes the active theme.
   */
  final public static function initialize() {
    static $initialized = FALSE;
    if (!$initialized) {
      // Initialize the active theme.
      $active_theme = self::getTheme();

      // Include deprecated functions.
      foreach ($active_theme->getAncestry() as $ancestor) {
        if ($ancestor->getSetting('include_deprecated')) {
          $files = $ancestor->fileScan('/^deprecated\.php$/');
          if ($file = reset($files)) {
            $ancestor->includeOnce($file->uri, FALSE);
          }
        }
      }

      $initialized = TRUE;
    }
  }

  /**
   * Manages theme alter hooks as classes and allows sub-themes to sub-class.
   *
   * @param string $function
   *   The procedural function name of the alter (e.g. __FUNCTION__).
   * @param mixed $data
   *   The variable that was passed to the hook_TYPE_alter() implementation to
   *   be altered. The type of this variable depends on the value of the $type
   *   argument. For example, when altering a 'form', $data will be a structured
   *   array. When altering a 'profile', $data will be an object.
   * @param mixed $context1
   *   (optional) An additional variable that is passed by reference.
   * @param mixed $context2
   *   (optional) An additional variable that is passed by reference. If more
   *   context needs to be provided to implementations, then this should be an
   *   associative array as described above.
   */
  public static function alter($function, &$data, &$context1 = NULL, &$context2 = NULL) {
    static $theme;
    if (!isset($theme)) {
      $theme = self::getTheme();
    }

    // Immediately return if the active theme is not Bootstrap based.
    if (!$theme->subthemeOf('materialize')) {
      return;
    }

    // Extract the alter hook name.
    $hook = Unicode::extractHook($function, 'alter');

    // Handle form alters separately.
    if (strpos($hook, 'form') === 0) {
      $form_id = $context2;
      if (!$form_id) {
        $form_id = Unicode::extractHook($function, 'alter', 'form');
      }

      // Due to a core bug that affects admin themes, we should not double
      // process the "system_theme_settings" form twice in the global
      // hook_form_alter() invocation.
      // @see https://drupal.org/node/943212
      if ($context2 === 'system_theme_settings') {
        return;
      }

      // Retrieve a list of form definitions.
      $form_manager = new FormManager($theme);

      /** @var \Drupal\bootstrap\Plugin\Form\FormInterface $form */
      if ($form_manager->hasDefinition($form_id) && ($form = $form_manager->createInstance($form_id, ['theme' => $theme]))) {
        $data['#submit'][] = [get_class($form), 'submitForm'];
        $data['#validate'][] = [get_class($form), 'validateForm'];
        $form->alterForm($data, $context1, $context2);
      }
    }
    // Process hook alter normally.
    else {
      // Retrieve a list of alter definitions.
      $alter_manager = new AlterManager($theme);

      /** @var \Drupal\bootstrap\Plugin\Alter\AlterInterface $class */
      if ($alter_manager->hasDefinition($hook) && ($class = $alter_manager->createInstance($hook, ['theme' => $theme]))) {
        $class->alter($data, $context1, $context2);
      }
    }
  }

  /**
   * Preprocess theme hook variables.
   *
   * @param array $variables
   *   The variables array, passed by reference.
   * @param string $hook
   *   The name of the theme hook.
   * @param array $info
   *   The theme hook info.
   */
  public static function preprocess(array &$variables, $hook, array $info) {
    static $theme;
    if (!isset($theme)) {
      $theme = self::getTheme();
    }
    static $preprocess_manager;
    if (!isset($preprocess_manager)) {
      $preprocess_manager = new PreprocessManager($theme);
    }

    // Ensure that any default theme hook variables exist. Due to how theme
    // hook suggestion alters work, the variables provided are from the
    // original theme hook, not the suggestion.
    if (isset($info['variables'])) {
      $variables = NestedArray::mergeDeepArray([$info['variables'], $variables], TRUE);
    }

    // Add extra variables to all theme hooks.
    foreach (Materialize::extraVariables() as $key => $value) {
      if (!isset($variables[$key])) {
        $variables[$key] = $value;
      }
    }

    // Add active theme context.
    // @see https://www.drupal.org/node/2630870
    if (!isset($variables['theme'])) {
      $variables['theme'] = $theme->getInfo();
      $variables['theme']['name'] = $theme->getName();
      $variables['theme']['path'] = $theme->getPath();
      $variables['theme']['title'] = $theme->getTitle();
      $variables['theme']['settings'] = $theme->settings()->get();
    }

    // Invoke necessary preprocess plugin.
    if (isset($info['bootstrap preprocess'])) {
      if ($preprocess_manager->hasDefinition($info['bootstrap preprocess'])) {
        $class = $preprocess_manager->createInstance($info['bootstrap preprocess'], ['theme' => $theme]);
        /** @var \Drupal\bootstrap\Plugin\Preprocess\PreprocessInterface $class */
        $class->preprocess($variables, $hook, $info);
      }
    }
  }

}