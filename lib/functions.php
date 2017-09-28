<?php
/**
 * All helper functions can be found here
 *
 */

/**
 * Check a plugin setting for the allowed use of advanced publication options
 *
 * @return bool
 */
function blog_tools_use_advanced_publication_options() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = false;
	
	$setting = elgg_get_plugin_setting('advanced_publication', 'blog_tools');
	if ($setting === 'yes') {
		$result = true;
	}
	
	return $result;
}
