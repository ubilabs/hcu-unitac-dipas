<?php

namespace Drupal\dipas_stories;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

/**
 * Provides a view controller for a story step entity type.
 */
class StoryStepViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  protected function getBuildDefaults(EntityInterface $entity, $view_mode) {
    $build = parent::getBuildDefaults($entity, $view_mode);
    // The story step has no entity template itself.
    unset($build['#theme']);
    return $build;
  }

}
