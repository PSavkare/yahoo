<?php 

namespace Drupal\ws_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ws custom' block.
 *
 * @Block(
 *   id = "ws_custom_block",
 *   admin_label = @Translation("WS Custom Block"),
 *
 * )
 */
class WSCustom extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
  // do something
    return array(
      '#title' => 'Websolutions Agency',
      '#description' => 'Websolutions Agency is the industry leading Drupal development agency in Croatia'
    );
  }
}