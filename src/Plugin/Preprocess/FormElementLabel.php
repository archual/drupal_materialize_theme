<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Preprocess\FormElementLabel.
 */

namespace Drupal\materialize\Plugin\Preprocess;

use Drupal\materialize\Annotation\MaterializePreprocess;
use Drupal\materialize\Utility\Variables;

/**
 * Pre-processes variables for the "form_element_label" theme hook.
 *
 * @ingroup theme_preprocess
 *
 * @MaterializePreprocess("form_element_label")
 */
class FormElementLabel extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocessElement(Variables $variables, $hook, array $info) {
    $variables->map(['attributes']);
    $this->preprocessAttributes($variables, $hook, $info);
  }

}
