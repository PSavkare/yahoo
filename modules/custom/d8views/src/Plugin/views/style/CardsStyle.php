<?php
namespace Drupal\d8views\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin for the cards view.
 *
 * @ViewsStyle(
 *   id = "cards_style",
 *   title = @Translation("Cards Style"),
 *   help = @Translation("Displays content in cards."),
 *   theme = "d8views_cards_style",
 *   display_types = {"normal"}
 * )
 */
class CardsStyle extends StylePluginBase {

  /**
   * Specifies if the plugin uses row plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  // Class methods…
}