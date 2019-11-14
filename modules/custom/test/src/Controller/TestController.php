<?php
/**
 * @file
 * Contains \Drupal\tenders\Controller\Tendersdisplay.
 */
namespace Drupal\test\Controller;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class Display.
 *
 * @package Drupal\test\Controller
 */
class TestController extends ControllerBase {
  /**
  * showdata.
  *
  * @return string
  *   Return Table format data.
  */
  public function test_function(){

      return array(
        '#markup'=>"heloo World",
      );

  }
  
}