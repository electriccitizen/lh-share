<?php

namespace Drupal\react_quiz_stats;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Quiz stat entity entities.
 *
 * @ingroup react_quiz_stats
 */
class QuizStatEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Quiz stat entity ID');
    $header['name'] = $this->t('Name');
    $header['question'] = $this->t('Question');
    $header['correct_response'] = $this->t('Correct Answer');
    $header['date'] = $this->t('Date Answered');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\react_quiz_stats\Entity\QuizStatEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.quiz_stat_entity.edit_form',
      ['quiz_stat_entity' => $entity->id()]
    );
    $question_rid = $entity->question_rid->value;
    $para_storage = \Drupal::EntityTypeManager()->getStorage('paragraph');
    $question = $para_storage->loadRevision($question_rid);
    $row['question'] = strip_tags($question->question->value);
    $row['correct_response'] = ($entity->correct_response->value)?'Yes':'No';
    $row['date'] = date('F j Y - H:i', $entity->getCreatedTime());
    return $row + parent::buildRow($entity);
  }

}
