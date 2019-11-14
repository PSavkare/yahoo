<?php
namespace Drupal\sendmail\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\file\Entity\File;
use Drupal\Core\Form\FormState;
/**
 * Implements an example form.
 */
class MailForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mail_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
      $form = array();
      $form['#attributes']['enctype'] = "multipart/form-data";
      $form['from_field'] =  array(
        '#type'=>'textfield',
        '#title'=>'From',
        '#size'=> 30,
        '#required'=>TRUE,
        '#default_value'=> 'info@vamnicom.gov.in',
      );
      $form['subject'] = array(
        '#type'=>'textfield',
        '#title'=> 'Subject',
        '#size' => 40,
        '#required'=> TRUE,
      );
      $form['message'] =  array(
        '#type' => 'text_format',// to load the ckEditor options
        '#format' => 'full_html',
        '#title'=>'Message',
        '#size'=>20,
        '#required'=>TRUE,
      );
      $validators = array(
        'file_validate_extensions' => array('csv'),
      );
      $form['my_file'] = array(
        '#type' => 'managed_file',
        '#name' => 'my_file',
        '#title' => t('File *'),
        '#size' => 20,
        '#description' => t('CSV format only'),
        '#upload_validators' => $validators,
        '#upload_location' => 'public://my_files/',
      );
      $form['submit'] =  array(
        '#type'=>'submit',
        '#value'=>'Send',
      );
      return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('my_file') == NULL) {
      $form_state->setErrorByName('my_file', $this->t('No File is attached'));
    }
    return parent::validateForm($form, $form_state);
    }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $file = \Drupal::entityTypeManager()->getStorage('file')
                    ->load($form_state->getValue('my_file')[0]); // Just FYI. The file id will be stored as an array
     // And you can access every field you need via standard method
    $file =dpm($file->get('filename')->value);
    // Mail content creation
    /*foreach ($form_state->getValues() as $key => $value) {
            
     }*/
      $subject  = $form_state->getValue('subject');
      $message  = $form_state->getValue('message');
      $to       = "paurnimasavkare@gmail.com"; //\Drupal::currentUser()->getEmail();
      $from     = $form_state->getValue('from_field');
      $langcode = \Drupal::currentUser()->getPreferredLangcode();
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= 'To: '.$to. "\r\n";
      $headers .= 'From: '.$from . "\r\n";
      $newMail  = \Drupal::service('plugin.manager.mail');
      $params   = array(
        'attachments' => array(
            0 => array(
              'filecontent' => '<?xml version="1.0" encoding="UTF-8"? ><test><item /></test>',
              'filename' => $file,
              'filemime' => 'text/xml',
            )
        ),
        'subject' => $subject,
        'message' => $message['value'],
        'headers' => $headers['value']
      );
      $newMail->mail('sendmail', 'registerMail', $to, 'en', $params, $reply = NULL, $send = TRUE); 
    }
}
