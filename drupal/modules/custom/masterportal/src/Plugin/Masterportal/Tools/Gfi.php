<?php

/**
 * @license https://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html GPL-2.0-or-later
 */

namespace Drupal\masterportal\Plugin\Masterportal\Tools;

use Drupal\Core\Form\FormStateInterface;
use Drupal\masterportal\Plugin\Masterportal\PluginBase;
use Drupal\masterportal\PluginSystem\ToolPluginInterface;

/**
 * Defines a tool plugin implementation for Gfi.
 *
 * @ToolPlugin(
 *   id = "Gfi",
 *   title = @Translation("Gfi"),
 *   description = @Translation("A plugin that integrates the getFeatureInformation functionality."),
 *   configProperty = "gfi",
 *   isAddon = false
 * )
 */
class Gfi extends PluginBase implements ToolPluginInterface {

  /**
   * The label of this plugin in the Masterportal.
   *
   * @var string
   */
  protected $name;

  /**
   * Is this plugin active by default?
   *
   * @var bool
   */
  protected $active;

  /**
   * Is this plugin visible in the tools section of the menu?
   *
   * @var bool
   */
  protected $isVisibleInMenu;

  /**
   * {@inheritdoc}
   */
  public static function getDefaults() {
    return [
      'name' => 'Informationen abfragen',
      'active' => TRUE,
      'isVisibleInMenu' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getForm(FormStateInterface $form_state, $dependantSelector = FALSE, $dependantSelectorProperty = NULL, $dependantSelectorValue = NULL) {
    $states = [
      'required' => [$dependantSelector => [$dependantSelectorProperty => $dependantSelectorValue]],
    ];
    return [
      'name' => [
        '#type' => 'textfield',
        '#title' => $this->t('Name', [], ['context' => 'Masterportal']),
        '#default_value' => $this->name,
        '#states' => $states,
      ],
      'active' => [
        '#type' => 'checkbox',
        '#title' => $this->t('Active by default', [], ['context' => 'Masterportal']),
        '#description' => $this->t('Determines if the user has to actively activate this plugin or if it is active by default.', [], ['context' => 'Masterportal']),
        '#default_value' => $this->active,
      ],
      'isVisibleInMenu' => [
        '#type' => 'checkbox',
        '#title' => $this->t('Visible in menu', [], ['context' => 'Masterportal']),
        '#default_value' => $this->isVisibleInMenu,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfigurationArray(FormStateInterface $form_state) {
    return [
      'name' => $this->name,
      'active' => (bool) $this->active,
      'isVisibleInMenu' => (bool) $this->isVisibleInMenu,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function injectConfiguration(\stdClass &$pluginSection) {
    $pluginSection->name = $this->name;
    $pluginSection->active = $this->active;
    $pluginSection->isVisibleInMenu = $this->isVisibleInMenu;
  }

}
