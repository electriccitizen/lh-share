<?php

namespace Drupal\react_quiz\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Validates the Keyword constraint.
 */
class CorrectConstraintValidator extends ConstraintValidator implements ContainerInjectionInterface {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs the validation object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager construction.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function validate($field, Constraint $constraint) {
    $quiz_questions = $field->getValue();
    foreach ($quiz_questions as $responseList) {
      $count = 0;
      $responses = $responseList['subform']['responses'];
      unset($responses['add_more']);
      foreach ($responses as $response) {
        $correctAnswer = $response['subform']['correct_resp']['value'];
        if($correctAnswer == 1) {
         $count++;
        }
      }
      if ($count > 1) {
        $this->context->addViolation($constraint->ToCorrectAnswers);
      }
    }
  }
}
