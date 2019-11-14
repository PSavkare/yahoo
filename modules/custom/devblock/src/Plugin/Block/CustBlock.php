<?php
namespace Drupal\devblock\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a ' custom Block' block.
 *
 * @Block(
 *   id = "custom_block_id",
 *   admin_label = @Translation("Development Block"),
 *
 * )
 */
class CustBlock extends BlockBase {
/**
* {@inheritdoc}
*/
  public function build() {
    return array(
    	'#theme'	=> 'devblock',
      	'#title' 	=> 'Neosoft Technology',
      	'#body' 	=> 'Demo content showing right now',
    );
}
}