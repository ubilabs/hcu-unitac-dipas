<?php

/**
 * @license https://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html GPL-2.0-or-later
 */

namespace Drupal\dipas\PluginSystem;

/**
 * Interface ResponseKeyPluginManagerInterface.
 *
 * Defines the API for the plugin manager for response key plugins.
 *
 * @package Drupal\dipas\PluginSystem
 */
interface ResponseKeyPluginManagerInterface {

  /**
   * Returns a plugin definition for a requested response key or false, if no plugin exists for the key given.
   *
   * @param string $key
   *   The requested response key.
   *
   * @return array|false
   *   The plugin definition or false, if no plugin exists for the given key.
   */
  public function getPluginDefinition($key);

}
