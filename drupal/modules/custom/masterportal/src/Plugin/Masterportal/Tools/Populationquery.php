<?php

/**
 * @license https://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html GPL-2.0-or-later
 */

namespace Drupal\masterportal\Plugin\Masterportal\Tools;

use Drupal\Core\Form\FormStateInterface;
use Drupal\masterportal\Plugin\Masterportal\PluginBase;
use Drupal\masterportal\PluginSystem\ToolPluginInterface;

/**
 * Defines a tool plugin implementation for Populationquery.
 *
 * @ToolPlugin(
 *   id = "Populationquery",
 *   title = @Translation("Populationquery"),
 *   description = @Translation("A plugin that let's users query population values specifically for Hamburg."),
 *   configProperty = "einwohnerabfrage",
 *   isAddon = true
 * )
 */
class Populationquery extends PluginBase implements ToolPluginInterface {

  /**
   * The label of this plugin in the Masterportal.
   *
   * @var string
   */
  protected $name;

  /**
   * The icon this plugin uses in the UI.
   *
   * @var string
   */
  protected $glyphicon;

  /**
   * {@inheritdoc}
   */
  protected $onlyDesktop;

  /**
   * Is this plugin visible in desktop mode only?
   *
   * @var bool
   */


  /**
   * Service-ID of required population query service
   *
   * @var string
   */
  protected $populationReqServiceId;

  public static function getDefaults() {
    return [
      'name' => 'Einwohneranzahl abfragen',
      'glyphicon' => 'glyphicon-resize-full',
      'onlyDesktop' => FALSE,
      'populationReqServiceId' => "2",
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
      'glyphicon' => $this->getGlyphiconSelect(
        $this->glyphicon,
        'Please choose',
        $states
      ),
      'onlyDesktop' => [
        '#type' => 'checkbox',
        '#title' => $this->t('Desktop only?', [], ['context' => 'Masterportal']),
        '#default_value' => $this->onlyDesktop,
      ],
      'populationReqServiceId' => [
        '#type' => 'textfield',
        '#title' => $this->t('Service used for the population query.', [], ['context' => 'Masterportal']),
        '#default_value' => $this->populationReqServiceId,
        '#states' => $states,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfigurationArray(FormStateInterface $form_state) {
    return [
      'name' => $this->name,
      'glyphicon' => $this->glyphicon,
      'onlyDesktop' => $this->onlyDesktop,
      'populationReqServiceId' => $this->populationReqServiceId,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function injectConfiguration(\stdClass &$pluginSection) {
    $pluginSection->name = $this->name;
    $pluginSection->glyphicon = $this->glyphicon;
    $pluginSection->onlyDesktop = $this->onlyDesktop;
    $pluginSection->populationReqServiceId = $this->populationReqServiceId;
  }

}
