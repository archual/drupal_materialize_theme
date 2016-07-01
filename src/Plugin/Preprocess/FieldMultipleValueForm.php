<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Preprocess\FieldMultipleValueForm.
 */

namespace Drupal\materialize\Plugin\Preprocess;

use Drupal\materialize\Annotation\MaterializePreprocess;
use Drupal\materialize\Utility\Variables;

/**
 * Pre-processes variables for the "field_multiple_value_form" theme hook.
 *
 * @ingroup theme_preprocess
 *
 * @MaterializePreprocess("field_multiple_value_form")
 */
class FieldMultipleValueForm extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
//  public function preprocessElement(Variables $variables, $hook, array $info) {
//    // Wrap header columns in label element for Materialize.
//    if ($variables['multiple']) {
//      $header = [
//        [
//          'data' => [
//            '#prefix' => '<label class="label">',
//            'title' => ['#markup' => $variables->element->getProperty('title')],
//            '#suffix' => '</label>',
//          ],
//          'colspan' => 2,
//          'class' => ['field-label'],
//        ],
//        t('Order', [], ['context' => 'Sort order']),
//      ];
//
//      $variables['table']['#header'] = $header;
//    }
//  }

}
