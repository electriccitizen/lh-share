<?php

namespace Drupal\react_quiz_stats\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Quiz stat entity entities.
 *
 * @ingroup react_quiz_stats
 */
interface QuizStatEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Quiz stat entity name.
   *
   * @return string
   *   Name of the Quiz stat entity.
   */
  public function getName();

  /**
   * Sets the Quiz stat entity name.
   *
   * @param string $name
   *   The Quiz stat entity name.
   *
   * @return \Drupal\react_quiz_stats\Entity\QuizStatEntityInterface
   *   The called Quiz stat entity entity.
   */
  public function setName($name);

  /**
   * Gets the Quiz stat entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Quiz stat entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Quiz stat entity creation timestamp.
   *
   * @param int $timestamp
   *   The Quiz stat entity creation timestamp.
   *
   * @return \Drupal\react_quiz_stats\Entity\QuizStatEntityInterface
   *   The called Quiz stat entity entity.
   */
  public function setCreatedTime($timestamp);

}
