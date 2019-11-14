<?php
/**
 * @file
 * Contains \Drupal\crud\Controller\CrudController.
 */
namespace Drupal\crud\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Drupal\taxonomy\Entity\Term;
use Drupal\node\NodeInterface;
use Drupal\Component\Utility;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\taxonomy\Entity;
use Drupal\taxonomy\TermInterface;
use Drupal\user\UserInterface;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Class Display.
 *
 * @package Drupal\crud\Controller
 */
class CrudController extends ControllerBase { 

  /**
  *   Function To create node Programatically.
  */
  public function create_new_node() {
    $node= Node::create(['type' => 'article']);
    $node->set('title', 'Heloo This is the Demo Tender content created programatically');
    $body=[
        'value' => 'Helooo, This is body content ',
        'format' => 'basic_html',
    ];
    $node->set('body', $body);
    $node->status = 1;
    $node->enforceIsNew();
    $node->save();
    drupal_set_message( "Node with nid " . $node->id() . " saved!\n");
    
    return array (
      '#markup' => '<p>Created node ID :'.$node->id().'</p><p> Node Title : '.$node->title->value.'</p><p>Node Body :'.$node->body->value,
    );
  }

  /**
  *   Function To update node Programatically.
  */
  public function update_current_node(NodeInterface $node) {
    $old_title = $node->title->value;
    $node->set("title","This is Updated Node Title");
    $old_body = $node->body->value;
    $node->set('body', "Updated body content");
    $node->save();
    
    return array (
      '#markup' => '<p>Created node ID :'.$node->id().'</p><p> Node Title : '.$old_title.'</p><p>Node Body :'.$old_body .'<p>Updated node ID :'.$node->id().'</p><p>Updated Node Title : '.$node->title->value.'</p><p>Updated Node Body :'.$node->body->value
    );
  }

  /**
  *   Function To delete single node Programatically.
  */
  public function delete_single_node( NodeInterface $node)
  {
    $storage_handler = \Drupal::entityTypeManager()->getStorage("node");
    $storage_handler->delete(array($node));
    
    return array(
      '#markup' => 'Successfully Node Deleted Of ID :'.$node->id(),
    );
  }

  /**
  *   Function To create user Programatically.
  */
  public function create_user() {
    $file_image='/var/www/html/drupal/sites/default/files/profile/placeholder.png';             
    $file_content = file_get_contents($file_image);
    $directory = 'public://Images/';
    file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
    $file_image = file_save_data($file_content, $directory . basename($file_image),     FILE_EXISTS_REPLACE);
    $user = User::create([
            'name' =>'paurnima',    
            'mail' => 'paurnimaer@gmail.com',
            'pass' => 'password',
            'status' => 1,
            'roles' => array('editor','administrator'),
            'user_picture' => array('target_id' => $file_image->id()),
            'timezone'=> 'Indian/Christmas'
          ]);
    $user->save();

    return array(
      '#markup' => '<p>' . t('Created User ID:') .$user->id(). '</p>',
    );
  }

  /**
  *   Function To update user Programatically.
  */
  public function update_user(UserInterface $user) {
    $user->setPassword('string');
    $user->setEmail("vghsdhsdv@gmail.com");
    $user->setUsername('raniii');
    $user->save();

    return array(
      '#markup' => '<p>'.t('Updated User ID:').$user->id(). '</p>',
    );
  }

  /**
  *   Function To delete user account Programatically.
  */
  public function delete_user_account(UserInterface $user) {
    $storage_handler = \Drupal::entityTypeManager()->getStorage("user");
    $storage_handler->delete(array($user));
    
    return array(
      '#markup' => '<p>Deleted user of User ID:'.$user->id().'</p>',
    );
  }

  /**
  *   Function To add taxonomy term Programatically.
  */
  public function add_taxonomy_term() {
    $term = Term::create([
          'name' => 'pune',
          'vid' => 'cities',
          ])->save();
    
    return array(
      '#markup' => '<p>'.t('Taxonomy term Added Successfully:').$term.'</p>',
    );
  }

  /**
  *   Function To update taxonomy term Programatically.
  */
  public function update_taxonomy_term($tid) {
    $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
    $term_name = $term->getName();
    // Transforming taxonomy term value. Doing my stuff.
    $value = $term_name . " län";
    $term->setName($value);
    $term->save(); // Important!!!!  }

    return array(
      '#markup' => '<p>'.t('Taxonomy term Updated Successfully: Old Term name ').$term_name.'</p><br><p>New Name :'.$value.'</p>',
    );
}
  /**
  *   Function To delete taxonomy term Programatically.
  */
  public function delete_taxonomy_term ($tid) {
    $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
    $term_name = $term->getName();
    $term->delete($term);

    return array(
      '#markup' => 'Successfully Deleted Taxonomy Term-name:'.$term_name,
    );
  }
}