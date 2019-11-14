<?php

namespace Drupal\test\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "test_block",
 *   admin_label = @Translation("Test block"),
 *   category = @Translation("Hello World"),
 * )
 */
class TestBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
  	 $config = $this->getConfiguration();

    if (!empty($config['hello_block_name'])) {
      $name = $config['hello_block_name'];
    }
    else {
      $name = $this->t('to no one');
    }

    return [
      '#markup' => $this->t('Hello @name!', [
        '@name' => $name,
      ]),
    ];
  }
  /*public function defaultConfiguration() {
    $default_config = \Drupal::config('test.settings');
    return [
      'test_block_name' => $default_config->get('testt.name'),
    ];
 */

}