<?php

namespace Drupal\gallery\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Photo gallery edit forms.
 *
 * @ingroup gallery
 */
class PhotoGalleryForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\gallery\Entity\PhotoGallery */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Photo gallery.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Photo gallery.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.photo_gallery.canonical', ['photo_gallery' => $entity->id()]);
  }

}
