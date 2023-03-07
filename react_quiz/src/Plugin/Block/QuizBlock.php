<?php

namespace Drupal\react_quiz\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'React Quiz' Block.
 *
 * @Block(
 *   id = "quiz_block",
 *   admin_label = @Translation("Quiz block"),
 *   category = @Translation("Quiz"),
 * )
 */
class QuizBlock extends BlockBase {

  /**
   * {@inheritdoc}
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');
   // $node = $this->getContextValue('node');
    $uuid = 0;
    if ($node instanceof \Drupal\node\NodeInterface) {
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();

      if ($node->bundle() == "quiz") {
        $uuid = $node->get('uuid')->value;
      } elseif ($node->bundle() == "fact_sheet") {
        $nid = $node->id();
        $query = \Drupal::entityQuery('node')
          ->condition('type', 'quiz')
          ->condition('display_reference.target_id', $nid, '=');
        $nids = $query->execute();
        $quiznodes = $node->loadMultiple($nids);

        foreach ($quiznodes as $quiz) {
          if ($quiz->get('display_reference')->target_id == $nid) {
            $uuid = $quiz->get('uuid')->value;
          }
        }
      }
    }
    if ($uuid && $language == "en") {
      return [
        '#markup' => '<div id="quiz-app"></div>',
        '#cache' => [ 'contexts' => ['url'] ],
        '#attached' => [
          'library' => [
            'react_quiz/quiz',
          ],
          'drupalSettings' => [
            'quizID' => $uuid,
          ]
        ],
      ];
    }
  }
  public function getCacheMaxAge() {
    return 0;
  }
}