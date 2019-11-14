<?php
/**
 * @file
 * Contains \Drupal\tenders\Controller\Tendersdisplay.
 */
namespace Drupal\tenders\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Drupal\taxonomy\Entity\Term;

/**
 * Class Display.
 *
 * @package Drupal\tenders\Controller
 */
class TendersController extends ControllerBase {
  /**
  * showdata.
  *
  * @return string
  *   Return Table format data.
  */
  public function tenders_display(){
      $output = '';
      $counter=0;
      $tenders = \Drupal::database()->select('node_field_data','n')
                    ->fields('n',array('nid','uid','title','created'))
                    ->condition('n.type','tenders')
                    ->orderBy("n.created", "ASC")
                    ->condition('n.status',1)            
                    ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
                    ->limit(50)
                    ->execute();
      $rows = array();
      $header=array('Sr.No.','Title', 'Created' ,'Author' );
      foreach ($tenders as $row => $content) 
      {
          $account = \Drupal\user\Entity\User::load($content->uid); // pass your uid
          $name = $account->getUsername();
          $counter= $counter+1;
          $node =$content->nid;
          $Editurl = Url::fromRoute('entity.node.canonical', array('node' => $node));
          $Editlink = Link::fromTextAndUrl($content->title, $Editurl );
          $rows[] = array(
              'data' => array($counter, $Editlink, date('Y-m-d', $content->created), $name));     
      }
      $output = array(
          '#type'   => 'table',    // Here you can write #type also instead of #theme.
          '#header' => $header,
          '#rows'   => $rows
      );
      $output['pager'] = array(
          '#type' => 'pager'
      );
      return $output;
  }
  public function admin_tender() {
      $nids = db_select('node_field_data','n')
                ->fields('n')
                ->condition('type', 'tenders')
                ->orderBy('created', 'asc')
                ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
                ->limit(10)
                ->execute();
        //Prepare table header
        $header = array('Sr. No.','Title', 'Type', 'Author', 'Status', 'Changed', 'Edit','Delete');
        //Build the rows.  
        $options = array();
        $counter=0; 
        foreach ($nids as $node => $content) 
        {
            $account = \Drupal\user\Entity\User::load($content->uid); // pass your uid
            $name = $account->getUsername();
            $counter= $counter+1;
            $Editurl = Url::fromRoute('entity.node.edit_form', array('node' => $content->nid));
            $Editlink = Link::fromTextAndUrl('Edit', $Editurl );
            $Deleteurl = Url::fromRoute('entity.node.delete_form', array('node' => $content->nid));
            $Deletelink = Link::fromTextAndUrl('Delete', $Deleteurl );
            $options[]= array
            (
              'sr. no.' =>$counter, 
              'title'   =>$content->title,
              'type'    =>$content->type,
              'author'  =>$name,
              'status'  =>$content->status? t('published') : t('not published'),
              'changed' =>format_date($content->changed, 'short'),
              'edit'    =>$Editlink,
              'delete'  => $Deletelink
            );
        }
        $output['table'] = 
        [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $options,
        ];
        $output['pager'] = array(
          '#type' => 'pager'
        );
    return $output;
  }
}