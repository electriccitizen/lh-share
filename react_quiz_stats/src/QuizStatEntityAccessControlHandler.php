<?php

namespace Drupal\react_quiz_stats;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Quiz stat entity entity.
 *
 * @see \Drupal\react_quiz_stats\Entity\QuizStatEntity.
 */
class QuizStatEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\react_quiz_stats\Entity\QuizStatEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished quiz stat entity entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published quiz stat entity entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit quiz stat entity entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete quiz stat entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add quiz stat entity entities');
  }


}
