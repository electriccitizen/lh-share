<?php

namespace Drupal\react_quiz\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Validates the Keyword field for usage.
 *
 * @Constraint(
 *   id = "CorrectFieldLimit",
 *   label = @Translation("Correct Field Limit", context = "Validation"),
 *   type = "string"
 * )
 */
class CorrectConstraint extends Constraint {

  /**
   * Violation message when the keyword is already used on three other entities.
   *
   * @var string
   */
  public $ToCorrectAnswers = 'There may only be one correct response per question.';
}
