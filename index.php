<?php

/*
  Plugin Name: ACF Block Icon
  Plugin URI: https://renderdev.com/
  Author: Phil Faciana - Render Dev
  Author URI: https://renderdev.com/
  Description: ACF Block Icon
  Version: 1.0.0
  Requires: 5.0.0
  Tested: 5.0.2
 */

/*
 * You can uncomment the following line for testing/debugging only
 * Otherwise just view as a reference example
 */
//include_once __DIR__ . '/test/acf_example.php';


require_once 'ACF_Block_Icon.php';

add_action('enqueue_block_editor_assets', function () {
	wp_enqueue_script('acf-block-icon-js', plugins_url('/acf-block-icon.js', __FILE__), array('jquery'), filemtime(__DIR__ . '/acf-block-icon.js'), TRUE);
});

add_action('acf/enqueue_scripts', function () {
	if (!$blocks = acf_get_block_types()) {
		return;
	}

	foreach ($blocks as $block) {
		acf_remove_block_type($block['name']);
		$block['name'] = substr($block['name'], 4);
		if (is_string($block['icon'])) {
			$block['icon'] = (new ACF_Block_Icon($block['icon']))->get_json();
		}
		elseif (is_array($block['icon']) && is_string($block['icon']['src'])) {
			$block['icon']['src'] = (new ACF_Block_Icon($block['icon']['src']))->get_json();
		}
		acf_register_block_type($block);
	}

	return;
}, 1, 0);