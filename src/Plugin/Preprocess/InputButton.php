<?php
/**
 * @file
 * Contains \Drupal\materialize\Plugin\Preprocess\InputButton.
 */

namespace Drupal\materialize\Plugin\Preprocess;

use Drupal\materialize\Annotation\MaterializePreprocess;
use Drupal\materialize\Utility\Variables;

/**
 * Pre-processes variables for the "input__button" theme hook.
 *
 * @ingroup theme_preprocess
 *
 * @MaterializePreprocess("input__button")
 */
class InputButton extends Input implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocessElement(Variables $variables, $hook, array $info) {
    $variables->element->colorize();
    $variables->element->setButtonSize();
    $variables->element->setIcon($variables->element->getProperty('icon'));
    $variables['icon_only'] = $variables->element->getProperty('icon_only');
    $variables['label'] = $variables->element->getProperty('value');
    if ($variables->element->getProperty('split')) {
      $variables->map([$variables::SPLIT_BUTTON]);
    }
    parent::preprocessElement($variables, $hook, $info);
  }

}
