<?php

namespace Drupal\gallery;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Photo gallery entity.
 *
 * @see \Drupal\gallery\Entity\PhotoGallery.
 */
class PhotoGalleryAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\gallery\Entity\PhotoGalleryInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished photo gallery entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published photo gallery entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit photo gallery entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete photo gallery entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add photo gallery entities');
  }

}
