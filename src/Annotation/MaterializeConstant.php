<?php
/**
 * @file
 * Contains \Drupal\materialize\Annotation\BootstrapConstant.
 */

namespace Drupal\materialize\Annotation;

use Doctrine\Common\Annotations\AnnotationException;
use Drupal\Component\Annotation\AnnotationBase;

/**
 * Defines a MaterializeConstant annotation object.
 *
 * @Annotation
 */
class MaterializeConstant extends AnnotationBase {

  /**
   * The stored constant value.
   *
   * @var mixed
   */
  protected $value;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $values) {
    $string = $values['value'];

    // Handle classes.
    if (strpos($string, '::') !== FALSE) {
      list($class, $constant) = explode('::', $string);
      try {
        $reflection = new \ReflectionClass($class);
        if ($reflection->hasConstant($constant)) {
          $this->value = $reflection->getConstant($constant);
          return;
        }
      }
      catch (\ReflectionException $e) {
      }
    }

    // Handle procedural constants.
    if (!$this->value && defined($string)) {
      $this->value = constant($string);
      return;
    }

    throw AnnotationException::semanticalErrorConstants($this->value);
  }

  /**
   * {@inheritdoc}
   */
  public function get() {
    return $this->value;
  }

}
