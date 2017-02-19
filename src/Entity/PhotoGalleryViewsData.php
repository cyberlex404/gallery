<?php

namespace Drupal\gallery\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Photo gallery entities.
 */
class PhotoGalleryViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
