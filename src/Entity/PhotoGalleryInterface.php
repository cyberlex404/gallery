<?php

namespace Drupal\gallery\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Photo gallery entities.
 *
 * @ingroup gallery
 */
interface PhotoGalleryInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Photo gallery name.
   *
   * @return string
   *   Name of the Photo gallery.
   */
  public function getName();

  /**
   * Sets the Photo gallery name.
   *
   * @param string $name
   *   The Photo gallery name.
   *
   * @return \Drupal\gallery\Entity\PhotoGalleryInterface
   *   The called Photo gallery entity.
   */
  public function setName($name);

  /**
   * Gets the Photo gallery creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Photo gallery.
   */
  public function getCreatedTime();

  /**
   * Sets the Photo gallery creation timestamp.
   *
   * @param int $timestamp
   *   The Photo gallery creation timestamp.
   *
   * @return \Drupal\gallery\Entity\PhotoGalleryInterface
   *   The called Photo gallery entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Photo gallery published status indicator.
   *
   * Unpublished Photo gallery are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Photo gallery is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Photo gallery.
   *
   * @param bool $published
   *   TRUE to set this Photo gallery to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\gallery\Entity\PhotoGalleryInterface
   *   The called Photo gallery entity.
   */
  public function setPublished($published);

  /**
   * @param $photos \Drupal\file\Entity\File[]
   * @return \Drupal\gallery\Entity\PhotoGalleryInterface
   *   The called Photo gallery entity.
   */
  public function setPhotos($photos);

}
