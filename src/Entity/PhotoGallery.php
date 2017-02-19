<?php

namespace Drupal\gallery\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Photo gallery entity.
 *
 * @ingroup gallery
 *
 * @ContentEntityType(
 *   id = "photo_gallery",
 *   label = @Translation("Photo gallery"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\gallery\PhotoGalleryListBuilder",
 *     "views_data" = "Drupal\gallery\Entity\PhotoGalleryViewsData",
 *     "translation" = "Drupal\gallery\PhotoGalleryTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\gallery\Form\PhotoGalleryForm",
 *       "add" = "Drupal\gallery\Form\PhotoGalleryForm",
 *       "edit" = "Drupal\gallery\Form\PhotoGalleryForm",
 *       "delete" = "Drupal\gallery\Form\PhotoGalleryDeleteForm",
 *     },
 *     "access" = "Drupal\gallery\PhotoGalleryAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\gallery\PhotoGalleryHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "photo_gallery",
 *   data_table = "photo_gallery_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer photo gallery entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/gallery/{photo_gallery}",
 *     "add-form" = "/admin/structure/photo_gallery/add",
 *     "edit-form" = "/admin/structure/photo_gallery/{photo_gallery}/edit",
 *     "delete-form" = "/admin/structure/photo_gallery/{photo_gallery}/delete",
 *     "collection" = "/admin/structure/photo_gallery",
 *   },
 *   field_ui_base_route = "photo_gallery.settings"
 * )
 */
class PhotoGallery extends ContentEntityBase implements PhotoGalleryInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
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
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * @param $photos
   * @return $this
   */
  public function setPhotos($photos) {
    $this->set('photos', $photos);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Photo gallery entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'hidden',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Photo gallery entity.'))
      ->setSettings(array(
        'max_length' => 250,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['photos'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Photos'))
      ->setDescription(t('Gallery photos'))
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setSetting('target_type', 'file')
      ->setSetting('file_directory', 'gallery/photos')
      ->setSetting('alt_field', FALSE)
      ->setSetting('alt_field_required', FALSE)
      ->setSetting('title_field', TRUE)
      ->setSetting('min_resolution', '600x600')
      ->setSetting('max_filesize', '10 Mb')
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'image',
      ))
      ->setDisplayOptions('form', array(
        'type' => 'image',
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Photo gallery is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
