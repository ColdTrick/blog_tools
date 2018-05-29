<?php

namespace ColdTrick\BlogTools;

use Elgg\ViewsService;

class Views {
	
	/**
	 * Change some of the view vars for the blog/save form
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current_return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function blogEditFormVars($hook, $type, $return_value, $params) {
		
		$action_name = elgg_extract('action_name', $return_value);
		if ($action_name !== 'blog/save') {
			return;
		}
		
		// add ability to upload icon
		$return_value['enctype'] = 'multipart/form-data';
		
		return $return_value;
	}
	
	/**
	 * Prevent the blog/sidebar/archives from being draw
	 *
	 * @param \Elgg\Hook $hook 'view_vars', 'blog/sidebar/archives'
	 *
	 * @return void|array
	 */
	public static function preventBlogArchiveSidebar(\Elgg\Hook $hook) {
		
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return;
		}
		
		$return = $hook->getValue();
		$return[ViewsService::OUTPUT_KEY] = '';
		
		return $return;
	}
}
