<?php

/**
 * @license https://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html GPL-2.0-or-later
 */

namespace Drupal\dipas\Plugin\SettingsSection;

use Drupal\Component\DependencyInjection\Container;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Class MenuSettings.
 *
 * @SettingsSection(
 *   id = "MenuSettings",
 *   title = @Translation("Menu settings"),
 *   description = @Translation("Settings related to the site menus the user is provided with."),
 *   weight = 50,
 *   affectedConfig = {}
 * )
 *
 * @package Drupal\dipas\Plugin\SettingsSection
 */
class MenuSettings extends SettingsSectionBase {

  use NodeSelectionTrait;
  
  /**
   * @var array
   */
  protected $materialIcons;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\masterportal\Service\InstanceServiceInterface
   */
  protected $instanceService;

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $nodeStorage;

  /**
   * {@inheritdoc}
   */
  protected function setAdditionalDependencies(Container $container) {
    $this->entityTypeManager = $container->get('entity_type.manager');
    $this->instanceService = $container->get('masterportal.instanceservice');
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  /**
   * {@inheritdoc}
   */
  public static function getDefaults() {
    return [
      'mainmenu' => [
        'contributionmap' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('Contribution map', [], ['context' => 'DIPAS']),
          'icon' => 'room',
        ],
        'contributionlist' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('Contribution list', [], ['context' => 'DIPAS']),
          'icon' => 'sms',
        ],
        'projectinfo' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('About the proceeding', [], ['context' => 'DIPAS']),
          'icon' => 'info',
          'node' => '',
        ],
        'schedule' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('Appointments', [], ['context' => 'DIPAS']),
          'icon' => 'event',
          'mapinstance' => 'default',
        ],
        'statistics' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('Analysis', [], ['context' => 'DIPAS']),
          'icon' => 'timeline',
        ],
        'survey' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('Poll', [], ['context' => 'DIPAS']),
          'icon' => 'phone',
          'url' => '',
        ],
        'custompage' => [
          'enabled' => 0,
          'name' => new TranslatableMarkup('my page', [], ['context' => 'DIPAS']),
          'icon' => 'keyboard',
          'node' => '',
        ],
        'conceptionlist' => [
          'enabled' => 0,
          'name' => new TranslatableMarkup('Compare concepts', [], ['context' => 'DIPAS']),
          'icon' => 'compare_arrows',
          'overwriteFrontpage' => 0,
        ],
      ],
      'footermenu' => [
        'dataprivacy' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('Privacy', [], ['context' => 'DIPAS']),
          'node' => '',
        ],
        'imprint' => ['enabled' => 1, 'name' => 'Impressum', 'node' => ''],
        'faq' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('FAQ', [], ['context' => 'DIPAS']),
          'node' => '',
        ],
        'contact' => [
          'enabled' => 1,
          'name' => new TranslatableMarkup('Contact', [], ['context' => 'DIPAS']),
          'node' => '',
        ],
      ],
      'frontpage' => 'contributionmap',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getForm(array $form, FormStateInterface $form_state) {
    $form = [
      '#tree' => TRUE,
      'mainmenu' => [
        '#type' => 'fieldset',
        '#title' => $this->t('Main menu settings', [], ['context' => 'DIPAS']),
      ],
      'footermenu' => [
        '#type' => 'fieldset',
        '#title' => $this->t('Footer menu settings', [], ['context' => 'DIPAS']),
      ],
    ];

    $defaults = static::getDefaults();

    foreach (['mainmenu', 'footermenu'] as $menu) {
      $menus = array_merge($defaults[$menu], $this->{$menu});
      foreach ($menus as $endpoint => $settings) {
        if ($endpoint === 'conceptionlist') {
          $enabledSettings = [
            '#type' => 'checkbox',
            '#title' => $this->t('Enabled', [], ['context' => 'DIPAS']),
            '#default_value' => '',
            '#weight' => 10,
            '#attributes' => [
              'disabled' => 'disabled',
            ],
            '#states' => [
              'checked' => [':input[type="checkbox"][name="settings[ProjectSchedule][phase_2_enabled]"]' => ['checked' => TRUE]],
            ],
          ];
        }
        else {
          $enabledSettings = [
            '#type' => 'checkbox',
            '#title' => $this->t('Enabled', [], ['context' => 'DIPAS']),
            '#default_value' => $settings['enabled'],
            '#weight' => 10,
          ];
        }
        $form[$menu][$endpoint] = [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['container-inline'],
          ],
          'endpoint' => [
            '#type' => 'value',
            '#value' => $endpoint,
          ],
          'menuitem' => [
            '#type' => 'markup',
            '#markup' => $this->t('Endpoint: %endpoint', ['%endpoint' => $defaults[$menu][$endpoint]['name']], ['context' => 'DIPAS']),
            '#prefix' => '<div class="endpointname">',
            '#suffix' => '</div>',
            '#weight' => 1,
          ],
          'enabled' => $enabledSettings,
          'name' => [
            '#type' => 'textfield',
            '#title' => $this->t('Name', [], ['context' => 'DIPAS']),
            '#default_value' => $settings['name'],
            '#required' => TRUE,
            '#size' => 20,
            '#weight' => 20,
          ],
        ];
        if ($menu === 'mainmenu') {
          $form[$menu][$endpoint]['icon'] = [
            '#type' => 'select',
            '#title' => $this->t('Icon', [], ['context' => 'DIPAS']),
            '#options' => $this->getMaterialIconOptions(),
            '#empty_option' => $this->t('Please select', [], ['context' => 'DIPAS']),
            '#default_value' => !empty($settings['icon']) ? $settings['icon'] : NULL,
            '#attributes' => ['class' => ['materialicons']],
            '#weight' => 30,
          ];

          $form[$menu][$endpoint]['frontpage'] = [
            '#tree' => FALSE,
            '#type' => 'radio',
            '#title' => $this->t('Frontpage', [], ['context' => 'DIPAS']),
            '#return_value' => $endpoint,
            '#default_value' => $this->frontpage === $endpoint || $defaults['frontpage'] === $endpoint ? $endpoint : NULL,
            '#required' => TRUE,
            '#states' => [
              'disabled' => [sprintf(':input[type="checkbox"][name="settings[MenuSettings][%s][%s][enabled]"]', $menu, $endpoint) => ['checked' => FALSE]],
            ],
            '#weight' => 10,
          ];
        }
        if (isset($settings['node']) || isset($defaults[$menu][$endpoint]['node'])) {
          $defaultValue = isset($settings['node'])
            ? $settings['node']
            : $defaults[$menu][$endpoint]['node'];

          $form[$menu][$endpoint]['node'] = [
            '#type' => 'select',
            '#title' => $this->t('Page', [], ['context' => 'DIPAS']),
            '#options' => $this->getPageOptions(),
            '#default_value' => $defaultValue,
            '#states' => [
              'required' => [sprintf(':input[type="checkbox"][name="settings[MenuSettings][%s][%s][enabled]"]', $menu, $endpoint) => ['checked' => TRUE]],
              'visible' => [sprintf(':input[type="checkbox"][name="settings[MenuSettings][%s][%s][enabled]"]', $menu, $endpoint) => ['checked' => TRUE]],
            ],
            '#weight' => 40,
          ];
        }

        if (isset($settings['mapinstance']) || isset($defaults[$menu][$endpoint]['mapinstance'])) {
          $form[$menu][$endpoint]['mapinstance'] = [
            '#type' => 'select',
            '#title' => $this->t('Map instance', [], ['context' => 'DIPAS']),
            '#required' => TRUE,
            '#empty_option' => $this->t('Please choose', [], ['context' => 'DIPAS']),
            '#options' => $this->instanceService->getInstanceOptions(['config', 'contribution']),
            '#states' => [
              'required' => [sprintf(':input[type="checkbox"][name="settings[MenuSettings][%s][%s][enabled]"]', $menu, $endpoint) => ['checked' => TRUE]],
            ],
            '#default_value' => $settings['mapinstance'],
            '#weight' => 50,
          ];
        }

        if (isset($settings['url']) || isset($defaults[$menu][$endpoint]['url'])) {
          $form[$menu][$endpoint]['url'] = [
            '#type' => 'textfield',
            '#title' => $this->t('URL', [], ['context' => 'DIPAS']),
            '#default_value' => $settings['url'],
            '#states' => [
              'required' => [sprintf(':input[type="checkbox"][name="settings[MenuSettings][%s][%s][enabled]"]', $menu, $endpoint) => ['checked' => TRUE]],
            ],
            '#size' => 50,
            '#weight' => 60,
          ];
        }

        if (isset($settings['overwriteFrontpage']) || isset($defaults[$menu][$endpoint]['overwriteFrontpage'])) {
          $form[$menu][$endpoint]['overwriteFrontpage'] = [
            '#title' => $this->t('Override Front page', [], ['context' => 'DIPAS']),
            '#description' => $this->t('Use Conceptions page instead of frontpage setting from menus section. It will only be overridden after phase 2 has started.', [], ['context' => 'DIPAS']),
            '#type' => 'checkbox',
            '#default_value' => $settings['overwriteFrontpage'],
            '#states' => [
              'disabled' => [sprintf(':input[type="checkbox"][name="settings[ProjectSchedule][phase_2_enabled]"]', $menu, $endpoint) => ['checked' => FALSE]],
            ],
            '#weight' => 70,
          ];
        }
      }
    }

    return $form;
  }

  /**
   * Loads the material icons and returns them as an array.
   *
   * @return array
   */
  protected function getMaterialIconOptions() {
    if ($this->materialIcons === NULL) {
      $this->materialIcons = include __DIR__ . '/MaterialIcons.inc.php';
    }
    return array_combine($this->materialIcons, $this->materialIcons);
  }

  /**
   * {@inheritdoc}
   */
  public static function getProcessedValues(array $plugin_values, array $form_values) {
    $sectionsettings = [];
    $sectionsettings['frontpage'] = $form_values['frontpage'];
    foreach ($plugin_values as $menuname => $section) {
      if (!isset($sectionsettings[$menuname])) {
        $sectionsettings[$menuname] = [];
      }
      foreach ($section as $settings) {
        $sectionsettings[$menuname][$settings['endpoint']] = [
          'enabled' => (bool) $settings['enabled'],
          'name' => $settings['name'],
        ];
        if ($menuname === 'mainmenu') {
          $sectionsettings[$menuname][$settings['endpoint']]['icon'] = $settings['icon'];
        }
        if (isset($settings['node'])) {
          $sectionsettings[$menuname][$settings['endpoint']]['node'] = $settings['node'];
        }
        if (isset($settings['mapinstance'])) {
          $sectionsettings[$menuname][$settings['endpoint']]['mapinstance'] = $settings['mapinstance'];
        }
        if (isset($settings['url'])) {
          $sectionsettings[$menuname][$settings['endpoint']]['url'] = $settings['url'];
        }
        if (isset($settings['overwriteFrontpage'])) {
          $sectionsettings[$menuname][$settings['endpoint']]['overwriteFrontpage'] = $settings['overwriteFrontpage'];
        }
      }
    }
    $sectionsettings['frontpage'] = $form_values['frontpage'];
    return $sectionsettings;
  }

  /**
   * {@inheritdoc}
   */
  public function onSubmit() {
  }

}
