<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Preprocess\Input.
 */

namespace Drupal\materialize\Plugin\Preprocess;

use Drupal\materialize\Annotation\MaterializePreprocess;
use Drupal\materialize\Utility\Variables;

/**
 * Pre-processes variables for the "select" theme hook.
 *
 * @ingroup theme_preprocess
 *
 * @MaterializePreprocess("select")
 */
class Select extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocessElement(Variables $variables, $hook, array $info) {
    // Create variables for #input_group and #input_group_button flags.
    $variables['input_group'] = $variables->element->getProperty('input_group') || $variables->element->getProperty('input_group_button');

    // Map the element properties.
    $variables->map([
      'attributes' => 'attributes',
      'field_prefix' => 'prefix',
      'field_suffix' => 'suffix',
    ]);

    // Ensure attributes are proper objects.
    $this->preprocessAttributes($variables, $hook, $info);
  }

}
