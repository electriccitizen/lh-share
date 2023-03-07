<?php

/**
 * @file
 * Contains quiz_stat_entity.page.inc.
 *
 * Page callback for Quiz stat entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Quiz stat entity templates.
 *
 * Default template: quiz_stat_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_quiz_stat_entity(array &$variables) {
  // Fetch QuizStatEntity Entity Object.
  $quiz_stat_entity = $variables['elements']['#quiz_stat_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
