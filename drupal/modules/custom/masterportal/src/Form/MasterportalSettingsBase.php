<?php

/**
 * @license https://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html GPL-2.0-or-later
 */

namespace Drupal\masterportal\Form;

use Drupal\Core\Cache\CacheTagsInvalidatorInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Render\Element;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Url;
use Drupal\masterportal\DomainAwareTrait;
use Drupal\masterportal\Service\LayerServiceInterface;
use Drupal\masterportal\Service\Masterportal;
use Drupal\masterportal\Service\MasterportalTokenServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MasterportalSettingsBase.
 *
 * Base definition for all setting forms for the Masterportal.
 *
 * @package Drupal\masterportal\Form
 */
abstract class MasterportalSettingsBase extends ConfigFormBase {
  use DomainAwareTrait;
  /**
   * The autogenerated namespace for the settings.
   *
   * @var string
   */
  protected $namespace;

  /**
   * The currently processed request.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $currentRequest;

  /**
   * Custom replacement service for module variables.
   *
   * @var \Drupal\masterportal\Service\MasterportalTokenServiceInterface
   */
  protected $tokenService;

  /**
   * Drupal's cache tags invalidator service.
   *
   * @var \Drupal\Core\Cache\CacheTagsInvalidatorInterface
   */
  protected $cacheTagsInvalidator;

  /**
   * Drupal's key-value-storage.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Our custom layer service.
   *
   * @var \Drupal\masterportal\Service\LayerServiceInterface
   */
  protected $layerService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('request_stack'),
      $container->get('masterportal.tokens'),
      $container->get('cache_tags.invalidator'),
      $container->get('state'),
      $container->get('masterportal.layerservice')
    );
  }

  /**
   * MasterportalSettingsBase constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   Symfonys request stack.
   * @param \Drupal\masterportal\Service\MasterportalTokenServiceInterface $token_service
   *   Custom service to replace placeholders with dynamic values.
   * @param \Drupal\Core\Cache\CacheTagsInvalidatorInterface $cache_tags_invalidator
   *   Drupal's cache tags invalidator service.
   * @param \Drupal\Core\State\StateInterface $state
   *   Drupal's key-value-storage.
   * @param \Drupal\masterportal\Service\LayerServiceInterface $layer_service
   *   Custom layer service.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    RequestStack $request_stack,
    MasterportalTokenServiceInterface $token_service,
    CacheTagsInvalidatorInterface $cache_tags_invalidator,
    StateInterface $state,
    LayerServiceInterface $layer_service
  ) {
    parent::__construct($config_factory);
    $this->currentRequest = $request_stack->getCurrentRequest();
    $this->tokenService = $token_service;
    $this->cacheTagsInvalidator = $cache_tags_invalidator;
    $this->state = $state;
    $this->layerService = $layer_service;
    $class = get_called_class();
    $class = explode('\\', $class);
    $this->namespace = array_pop($class);

    $this->prepareForm();
  }

  /**
   * {@inheritdoc}
   */
  final public function getFormId() {
    return "masterportal.settingsform.{$this->namespace}";
  }

  /**
   * {@inheritdoc}
   */
  final public function buildForm(array $form, FormStateInterface $form_state) {
    // Get the form definition.
    $form = $this->getForm($form, $form_state);

    // Add a "cancel" link to the actions section.
    $form['actions']['cancel'] = [
      '#weight' => 999999,
      '#type' => 'html_tag',
      '#tag' => 'p',
      [
        '#type' => 'markup',
        '#markup' => Link::fromTextAndUrl(
          $this->t('Cancel changes and reload', [], ['context' => 'Masterportal']),
          Url::fromRoute($this->currentRequest->attributes->get('_route'))
        )->toString(),
      ],
      '#attributes' => [
        'style' => 'display: inline-block; margin-left: 20px;',
      ],
    ];

    // Convert the form to a system settings form and return it.
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  final public function submitForm(array &$form, FormStateInterface $form_state) {
    // Invalidate all caches related to this class.
    $cacheTagsToInvalidate = [
      sprintf(
        '%s:%s',
        Masterportal::CACHE_ID_PREFIX,
        $this->namespace
      ),
    ];
    $this->cacheTagsInvalidator->invalidateTags($cacheTagsToInvalidate);

    // Get the form definition.
    $form = $this->getForm($form, $form_state);

    // Get an editable instance of the settings.
    $config = $this->configFactory->getEditable($this->getSettingsKey());

    // Iterate over each form field.
    foreach (Element::children($form) as $key) {

      // Ignore non-custom keys.
      if (in_array($key, ['actions', 'form_build_id', 'form_token', 'form_id'])) {
        continue;
      }

      // Retrieve the configuration value.
      $value = $form_state->getValue($key);

      // Preprocess the configuration value if the form
      // provides a pre-save method.
      $this->preSave($key, $value, $form[$key], $form_state);

      // Set the value in the configuration object.
      $config->set($this->getVariableNameString($key), $value);

    }

    // Save the Configuration.
    $config->save();

    // Invoke potential post-save actions.
    $this->postSave($config->getRawData());

    // Delegate to parent.
    parent::submitForm($form, $form_state);
  }

  /**
   * Called in the constructor, allows concrete implementations to do preparatory work.
   */
  protected function prepareForm() {}

  /**
   * Proprocessor function for form values.
   *
   * @param string $key
   *   The variable name.
   * @param mixed $value
   *   The variable value.
   * @param array $formPortion
   *   The portion of the form currently processed.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The complete FormState object.
   */
  protected function preSave($key, &$value, array $formPortion, FormStateInterface $form_state) {}

  /**
   * Will be invoked after configuration save and get the saved values.
   *
   * @param array $values
   *   The saved configuration values.
   */
  protected function postSave(array $values) {}

  /**
   * Magic getter for setting variables.
   *
   * @param string $name
   *   The name of the desired settings variable.
   *
   * @return mixed|null
   *   The value (if set).
   */
  final public function __get($name) {
    // Get the config file.
    $config = $this->config($this->getSettingsKey());

    // Retrieve the desired value and return it.
    return $config->get($this->getVariableNameString($name));
  }

  /**
   * Prefixes the setting variable name with it's corresponding namespace.
   *
   * @param string $name
   *   The name of the variable.
   *
   * @return string
   *   The ready-to-use name string containing the variable domain.
   */
  private function getVariableNameString($name) {
    return sprintf('%s.%s', $this->namespace, $name);
  }

  /**
   * Returns the form definition of the current settings form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The complete settings form definition.
   */
  abstract protected function getForm(array $form, FormStateInterface $form_state);

  /**
   * Returns the key the settings should get stored under.
   *
   * @return string
   */
  abstract protected function getSettingsKey();

}
