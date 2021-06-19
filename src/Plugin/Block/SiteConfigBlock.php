<?php

namespace Drupal\assignment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\assignment\GetCurrentTimeByTimezone;
use Drupal\Core\Config\ConfigFactory;


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "site_config_block",
 *   admin_label = @Translation("Site Config Block"),
 * )
 */
class SiteConfigBlock extends BlockBase implements ContainerFactoryPluginInterface {
   /**
    * @var GetCurrentTimeByTimezone $currentTime.
    * @var ConfigFactory $configFactory.
    */
   protected $currentTime;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param Drupal\assignment\GetCurrentTimeByTimezone $currentTime;
   * @param Drupal\Core\Config\ConfigFactory $configFactory;
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, GetCurrentTimeByTimezone $currentTime, ConfigFactory $configFactory ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentTime = $currentTime;
    $this->configFactory = $configFactory;
  }
  
  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('assignment.get_current_time_by_timezone'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'datetime_with_timezone',
      '#country' => $this->configFactory->getEditable('site_config_form.adminsettings')->get('site_config_country'),
      '#city' => $this->configFactory->getEditable('site_config_form.adminsettings')->get('site_config_city'),
      '#date_time' => $this->currentTime->getTimeWithTimezone(),
      '#cache' => [
        'tags' => ['custom_site_config_tag'],
      ],
    ];
  }

}