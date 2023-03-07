<?php

namespace Drupal\react_quiz_stats\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Quiz stat entity entities.
 */
class QuizStatEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['quiz_stat_entity']['table']['base'] = [
      'field' => 'id',
      'title' => $this->t('Quiz Stat'),
      'help' => $this->t('The Quiz Stat Number'),
    ];

    $data['quiz_stat_entity']['quiz_id'] = [
      'title' => t('Quiz ID'),
      'help' => t('Quiz Nodes referenced by Quiz Stat'),
      'relationship' => [
        'base' => 'node_field_data',
        'base field' => 'nid',
        'id' => 'standard',
        'label' => t('Quiz Node')
      ]
    ];

    $data['quiz_stat_entity']['question_rid'] = [
      'title' => t('Question RID'),
      'help' => t('Question revision referenced by Quiz Stat'),
      'relationship' => [
        'base' => 'paragraphs_item_revision_field_data',
        'base field' => 'revision_id',
        'id' => 'standard',
        'label' => t('Paragraph Revisions')
      ]
    ];

    $data['quiz_stat_entity']['question_id'] = [
      'title' => t('Question ID'),
      'help' => t('Questions by Quiz Stat'),
      'relationship' => [
        'base' => 'paragraphs_item_field_data',
        'base field' => 'id',
        'id' => 'standard',
        'label' => t('Paragraphs')
      ]
    ];

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
