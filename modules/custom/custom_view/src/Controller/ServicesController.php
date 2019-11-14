<?php
/**
 * @file
 * Contains \Drupal\tenders\Controller\Tendersdisplay.
 */
namespace Drupal\custom_view\Controller;
use Drupal\Core\Controller\ControllerBase;

/**
 * 
 */
class ServicesController extends ControllerBase
{
	public function helloworld(){
		//$service = \Drupal::service('custom_services_example.say_hello');
		$service = \Drupal::service('custom_view.say_hello'); //Call the service by it's name  
		$re= $service->sayHello('Paurnima');//Pass variable to function sayHello()
	    return array(
	      '#markup' => $re,
	    );
	}
}