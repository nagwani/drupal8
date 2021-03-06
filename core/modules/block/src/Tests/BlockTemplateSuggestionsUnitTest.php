<?php

/**
 * @file
 * Definition of Drupal\block\Tests\BlockTemplateSuggestionsUnitTest.
 */

namespace Drupal\block\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests the block_theme_suggestions_block() function.
 *
 * @group block
 */
class BlockTemplateSuggestionsUnitTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('block');

  /**
   * Tests template suggestions from block_theme_suggestions_block().
   */
  function testBlockThemeHookSuggestions() {
    // Define a block with a derivative to be preprocessed, which includes both
    // an underscore (not transformed) and a hyphen (transformed to underscore),
    // and generates possibilities for each level of derivative.
    // @todo Clarify this comment.
    /** @var \Drupal\block\BlockInterface $block */
    $block = entity_create('block', array(
      'plugin' => 'system_menu_block:admin',
      'region' => 'footer',
      'id' => 'machinename',
    ));

    $variables = array();
    $plugin = $block->getPlugin();
    $variables['elements']['#configuration'] = $plugin->getConfiguration();
    $variables['elements']['#plugin_id'] = $plugin->getPluginId();
    $variables['elements']['#id'] = $block->id();
    $variables['elements']['#base_plugin_id'] = $plugin->getBaseId();
    $variables['elements']['#derivative_plugin_id'] = $plugin->getDerivativeId();
    $variables['elements']['content'] = array();
    $suggestions = block_theme_suggestions_block($variables);
    $this->assertEqual($suggestions, array('block__system', 'block__system_menu_block', 'block__system_menu_block__admin', 'block__machinename'));
  }

}
