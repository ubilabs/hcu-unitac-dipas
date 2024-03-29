<?php

/**
 * @license https://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html GPL-2.0-or-later
 */

namespace Drupal\masterportal\Plugin\Masterportal\Tools;

use Drupal\Core\Form\FormStateInterface;
use Drupal\masterportal\Plugin\Masterportal\PluginBase;
use Drupal\masterportal\PluginSystem\ToolPluginInterface;

/**
 * Defines a tool plugin implementation for Draw.
 *
 * @ToolPlugin(
 *   id = "Draw",
 *   title = @Translation("Draw"),
 *   description = @Translation("A plugin that let's users draw on the map."),
 *   configProperty = "draw",
 *   isAddon = false
 * )
 */
class Draw extends PluginBase implements ToolPluginInterface {

  /**
   * The label of this plugin in the Masterportal.
   *
   * @var string
   */
  protected $name;

  /**
   * Flag determining if this tool is listed in the Masterportal menu.
   *
   * @var boolean
   */
  protected $visibleInMenu;

   /**
   * Flag determining if this tool will be opened in window
   * 
   * @var boolean
   */
  protected $renderToWindow;

  /**
   * {@inheritdoc}
   */
  public static function getDefaults() {
    return [
      'name' => 'Zeichnen / Schreiben',
      'visibleInMenu' => TRUE,
      'renderToWindow' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getForm(FormStateInterface $form_state, $dependantSelector = FALSE, $dependantSelectorProperty = NULL, $dependantSelectorValue = NULL) {
    $states = [
      'invisible' => ['input[name=settings\[ToolSettings\]\[details_Draw\]\[pluginsettings\]\[visibleInMenu\]]' => ['checked' => FALSE]],
      'required' => [
        ['input[name=settings\[ToolSettings\]\[details_Draw\]\[pluginsettings\]\[visibleInMenu\]]' => ['checked' => TRUE]],
        [$dependantSelector => [$dependantSelectorProperty => $dependantSelectorValue]],
      ],
    ];
    return [
      'visibleInMenu' => [
        '#type' => 'checkbox',
        '#title' => $this->t('Draw-Tool is visible in Masterportal menu', [], ['context' => 'Masterportal']),
        '#description' => $this->t('Uncheck to hide this tool from being listed in the Masterportal menu.', [], ['context' => 'Masterportal']),
        '#default_value' => $this->visibleInMenu,
      ],
      'renderToWindow' => [
        '#type' => 'checkbox',
        '#title' => $this->t('Draw-Tool opens in a seperate window', [], ['context' => 'Masterportal']),
        '#description' => $this->t('Check, to open this tool in a seperate window.', [], ['context' => 'Masterportal']),
        '#default_value' => $this->renderToWindow ?? FALSE,
      ],
      'name' => [
        '#type' => 'textfield',
        '#title' => $this->t('Name', [], ['context' => 'Masterportal']),
        '#default_value' => $this->name,
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
      'visibleInMenu' => $this->visibleInMenu,
      'renderToWindow' => $this->renderToWindow,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function injectConfiguration(\stdClass &$pluginSection) {
    $pluginSection->name = $this->name;
    $pluginSection->visibleInMenu = $this->visibleInMenu;
    $pluginSection->renderToWindow = $this->renderToWindow ?? FALSE;
  }

}
