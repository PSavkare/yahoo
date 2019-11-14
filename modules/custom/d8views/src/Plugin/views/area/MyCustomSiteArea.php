<?php
/**
 * @file
 * Contains \Drupal\module_name\Plugin\views\area\MyCustomSiteArea.
 */
namespace Drupal\module_name\Plugin\views\area;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Plugin\views\area\AreaPluginBase;
/**
 * Views area MyCustomSiteArea handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("my_custom_site_area")
 */
class MyCustomSiteArea extends AreaPluginBase {
  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    return $options;
  }
  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    // We check if the views result are empty, or if the settings of this area 
    // force showing this area even if the view is empty.
    if (!$empty || !empty($this->options['empty'])) {
      $output = array();
      $output['text'] = [
        '#type' => 'processed_text',
        '#text' => '<p>' . $this->t('My custom site hardcoded text') . '</p>',
        '#format' => 'full_html',
      ];
      // My awesome return link to frontpage with custom classes.
      $output['link'] = [
        '#title' => $this->t('< Back to the front'),
        '#type' => 'link',
        '#url' => Url::fromRoute('<front>'),
        '#attributes' => [
          'class' => ['button', 'secondary']
        ]
      ];
      
      return $output;
    }
    return array();
  }
}