<?php

namespace Drupal\react_quiz_stats\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Quiz stat entity entity.
 *
 * @ingroup react_quiz_stats
 *
 * @ContentEntityType(
 *   id = "quiz_stat_entity",
 *   label = @Translation("Quiz stat entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\react_quiz_stats\QuizStatEntityListBuilder",
 *     "views_data" = "Drupal\react_quiz_stats\Entity\QuizStatEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\react_quiz_stats\Form\QuizStatEntityForm",
 *       "add" = "Drupal\react_quiz_stats\Form\QuizStatEntityForm",
 *       "edit" = "Drupal\react_quiz_stats\Form\QuizStatEntityForm",
 *       "delete" = "Drupal\react_quiz_stats\Form\QuizStatEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\react_quiz_stats\QuizStatEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\react_quiz_stats\QuizStatEntityAccessControlHandler",
 *   },
 *   base_table = "quiz_stat_entity",
 *   translatable = FALSE,
 *   admin_permission = "administer quiz stat entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/quiz_stat_entity/{quiz_stat_entity}",
 *     "add-form" = "/admin/structure/quiz_stat_entity/add",
 *     "edit-form" = "/admin/structure/quiz_stat_entity/{quiz_stat_entity}/edit",
 *     "delete-form" = "/admin/structure/quiz_stat_entity/{quiz_stat_entity}/delete",
 *     "collection" = "/admin/structure/quiz_stat_entity",
 *   },
 *   field_ui_base_route = "quiz_stat_entity.settings"
 * )
 */
class QuizStatEntity extends ContentEntityBase implements QuizStatEntityInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Quiz stat entity entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Quiz stat entity entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -10,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['question_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Question ID'))
      ->setDescription(t('The paragraph ID of the question'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['question_rid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Question RID'))
      ->setDescription(t('The paragraph RID of the question'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['quiz_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Quiz ID'))
      ->setDescription(t('The quiz ID'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status']->setDescription(t('Published'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => 10,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'))
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
      ));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['correct_response'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Correct Response'))
      ->setDescription(t('Log a correct response'))
      ->setDisplayOptions('form', array(
        'type' => 'boolean_checkbox',
        "weight" => -1,
        'settings' => array(
          'display_label' => TRUE,
        ),
      ))
      ->setDisplayOptions('view', array(
        'type' => 'boolean_checkbox',
        "weight" => -4,
        'settings' => array(
          'display_label' => TRUE,
        ),
      ))
      ->setDisplayConfigurable('form', TRUE);

    return $fields;
  }

}
