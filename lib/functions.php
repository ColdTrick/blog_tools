<?php
/**
 * Helper functions can be found here
 */

function blog_tools_get_icon_settings(\ElggBlog $entity, $full_view = false) {
	static $settings;
	
	if (!$entity instanceof ElggBlog) {
		return false;
	}
	
	$full_view = (bool) $full_view;
	
	if (isset($settings)) {
		return $full_view ? $settings['full'] : $settings['listing'];
	}
	
	$plugin_settings = elgg_get_plugin_from_id('blog_tools')->getAllSettings();
	
	$settings = [
		'full' => [
			'align' => elgg_extract('full_align', $plugin_settings),
			'size' => elgg_extract('full_size', $plugin_settings),
			'icon_wrapper' => true,
		],
		'listing' => [
			'align' => elgg_extract('listing_align', $plugin_settings),
			'size' => elgg_extract('listing_size', $plugin_settings),
			'icon_wrapper' => true,
		],
	];
	
	return $full_view ? $settings['full'] : $settings['listing'];
}
