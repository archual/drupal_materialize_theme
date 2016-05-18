<?php
/**
 * @file
 * Contains \Drupal\materialize.
 */

namespace Drupal\materialize;

//use Drupal\bootstrap\Plugin\ProviderManager;
//use Drupal\bootstrap\Plugin\SettingManager;
//use Drupal\bootstrap\Plugin\UpdateManager;
//use Drupal\bootstrap\Utility\Crypt;
//use Drupal\bootstrap\Utility\Storage;
//use Drupal\bootstrap\Utility\StorageItem;
use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ThemeHandlerInterface;

/**
 * Defines a theme object.
 */
class Theme {
  /**
   * The current theme info.
   *
   * @var array
   */
  protected $info;

  /**
   * The current theme Extension object.
   *
   * @var \Drupal\Core\Extension\Extension
   */
  protected $theme;

  /**
   * An array of installed themes.
   *
   * @var array
   */
  protected $themes;

  /**
   * Theme handler object.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * Theme constructor.
   *
   * @param \Drupal\Core\Extension\Extension $theme
   *   A theme \Drupal\Core\Extension\Extension object.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler object.
   */
  public function __construct(Extension $theme, ThemeHandlerInterface $theme_handler) {
    $name = $theme->getName();
    $this->theme = $theme;
    $this->themeHandler = $theme_handler;
    $this->themes = $this->themeHandler->listInfo();
    $this->info = isset($this->themes[$name]->info) ? $this->themes[$name]->info : [];

    // Only install the theme if there is no schema version currently set.
    if (!$this->getSetting('schema')) {
      $this->install();
    }
  }

  /**
   * Returns the theme machine name.
   *
   * @return string
   *   Theme machine name.
   */
  public function __toString() {
    return $this->getName();
  }

  /**
   * Retrieves the theme info.
   *
   * @param string $property
   *   A specific property entry from the theme's info array to return.
   *
   * @return array
   *   The entire theme info or a specific item if $property was passed.
   */
  public function getInfo($property = NULL) {
    if (isset($property)) {
      return isset($this->info[$property]) ? $this->info[$property] : NULL;
    }
    return $this->info;
  }

  /**
   * Returns the machine name of the theme.
   *
   * @return string
   *   The machine name of the theme.
   */
  public function getName() {
    return $this->theme->getName();
  }

  /**
   * Returns the relative path of the theme.
   *
   * @return string
   *   The relative path of the theme.
   */
  public function getPath() {
    return $this->theme->getPath();
  }

  /**
   * Retrieves a theme setting.
   *
   * @param string $name
   *   The name of the setting to be retrieved.
   * @param bool $original
   *   Retrieve the original default value from code (or base theme config),
   *   not from the active theme's stored config.
   *
   * @return mixed
   *   The value of the requested setting, NULL if the setting does not exist.
   *
   * @see theme_get_setting()
   */
  public function getSetting($name, $original = FALSE) {
    if ($original) {
      return $this->settings()->getOriginal($name);
    }
    return $this->settings()->get($name);
  }

  /**
   * Retrieves the theme's setting plugin instances.
   *
   * @return \Drupal\materialize\Plugin\Setting\SettingInterface[]
   *   An associative array of setting objects, keyed by their name.
   */
  public function getSettingPlugins() {
    $settings = [];
    $setting_manager = new SettingManager($this);
    foreach (array_keys($setting_manager->getDefinitions()) as $setting) {
      $settings[$setting] = $setting_manager->createInstance($setting);
    }
    return $settings;
  }

  /**
   * Retrieves the theme's cache from the database.
   *
   * @return \Drupal\bootstrap\Utility\Storage
   *   The cache object.
   */
  public function getStorage() {
    static $cache = [];
    $theme = $this->getName();
    if (!isset($cache[$theme])) {
      $cache[$theme] = new Storage($theme);
    }
    return $cache[$theme];
  }

  /**
   * Retrieves the human-readable title of the theme.
   *
   * @return string
   *   The theme title or machine name as a fallback.
   */
  public function getTitle() {
    return $this->getInfo('name') ?: $this->getName();
  }

  /**
   * Includes a file from the theme.
   *
   * @param string $file
   *   The file name, including the extension.
   * @param string $path
   *   The path to the file in the theme. Defaults to: "includes". Set to FALSE
   *   or and empty string if the file resides in the theme's root directory.
   *
   * @return bool
   *   TRUE if the file exists and is included successfully, FALSE otherwise.
   */
  public function includeOnce($file, $path = 'includes') {
    static $includes = [];
    $file = preg_replace('`^/?' . $this->getPath() . '/?`', '', $file);
    $file = strpos($file, '/') !== 0 ? $file = "/$file" : $file;
    $path = is_string($path) && !empty($path) && strpos($path, '/') !== 0 ? $path = "/$path" : '';
    $include = DRUPAL_ROOT . '/' . $this->getPath() . $path . $file;
    if (!isset($includes[$include])) {
      $includes[$include] = !!@include_once $include;
      if (!$includes[$include]) {
        drupal_set_message(t('Could not include file: @include', ['@include' => $include]), 'error');
      }
    }
    return $includes[$include];
  }

  /**
   * Installs a Bootstrap based theme.
   */
  final protected function install() {
    $update_manager = new UpdateManager($this);
    $this->setSetting('schema', $update_manager->getLatestVersion());
  }

  /**
   * Removes a theme setting.
   *
   * @param string $name
   *   Name of the theme setting to remove.
   */
  public function removeSetting($name) {
    $this->settings()->clear($name)->save();
  }

  /**
   * Sets a value for a theme setting.
   *
   * @param string $name
   *   Name of the theme setting.
   * @param mixed $value
   *   Value to associate with the theme setting.
   */
  public function setSetting($name, $value) {
    $this->settings()->set($name, $value)->save();
  }

  /**
   * Retrieves the theme settings instance.
   *
   * @return \Drupal\materialize\ThemeSettings
   *   All settings.
   */
  public function settings() {
    static $themes = [];
    $name = $this->getName();
    if (!isset($themes[$name])) {
      $themes[$name] = new ThemeSettings($this, $this->themeHandler);
    }
    return $themes[$name];
  }

  /**
   * Determines whether or not a theme is a sub-theme of another.
   *
   * @param string|\Drupal\materialize\Theme $theme
   *   The name or theme Extension object to check.
   *
   * @return bool
   *   TRUE or FALSE
   */
  public function subthemeOf($theme) {
    return (string) $theme === $this->getName() || in_array($theme, array_keys(self::getAncestry()));
  }
}