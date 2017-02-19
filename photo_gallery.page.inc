<?php

/**
 * @file
 * Contains photo_gallery.page.inc.
 *
 * Page callback for Photo gallery entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Photo gallery templates.
 *
 * Default template: photo_gallery.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_photo_gallery(array &$variables) {
  // Fetch PhotoGallery Entity Object.
  $photo_gallery = $variables['elements']['#photo_gallery'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
