<?php
/**
 * @file
 * Contains \Drupal\import_node\Controller\NodeimportController.
 */
namespace Drupal\import_node\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Drupal\Component\Utility;
/**
 * Class Display.
 *
 * @package Drupal\import_node\Controller
 */
class NodeimportController extends ControllerBase {
  /**
   * User Import.
   *
   * @return string
   *   Return Table format data.
   */
  /*public function content(Request $request) {

    $form = \Drupal::formBuilder()->getForm('Drupal\import_node\Form\ImportForm');
    
    return $form;
  }*/
  public function import_node()
  {
    $row = 1;
    $absolute_path = \Drupal::service('file_system')->realpath('public://import_node.csv');
    if (($handle = fopen( $absolute_path, "r")) !== FALSE) 
    {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        if($row == 1){ $row++; continue; }
        $row++;
        return $this->create_node($data);
      }
      fclose($handle);
    }  
  }
  public function create_node($data){
    //var_dump($data);
    //var_dump($items);
    $type=$data[0];
   /* echo "string".$type;
    exit();*/
    /*echo $type;
    exit();*/
    $title=$data[1];
    $content=$data[2];
    $node = entity_create(
            'node', array(
              'type' => $type,
              'title' => $title,
              'body' => array(
                    'value' => $content,
                    'format' => 'full_html',
                  ),
              'field_date'=>[ date("Y-m-d") ],
            )
          );

    $node->save();
    drupal_set_message( "Node with nid " . $node->id() . " saved!\n");
    return array
    (
      '#markup' => '<p>Created node ID :'.$node->id().'</p><p> Node Title : '.$node->title->value.'</p><p>Node Body :'. $node->body->value .'<p>Node Type :'.$node->bundle(),
    );
    
    return array
    (
      '#markup' => '<p>Created node ID :'.$node->id().'</p><p> Node Title : '.$node->title->value.'</p><p>Node Body :'.$node->body->value,
    );
    
}
}