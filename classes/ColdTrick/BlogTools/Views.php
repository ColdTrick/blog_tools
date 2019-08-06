<?php

namespace ColdTrick\BlogTools;

use Elgg\ViewsService;

class Views {
	
	/**
	 * Change some of the view vars for the blog/save form
	 *
	 * @param \Elgg\Hook $hook 'view_vars', 'input/form'
	 *
	 * @return void|array
	 */
	public static function blogEditFormVars(\Elgg\Hook $hook) {
		
		$vars = $hook->getValue();
		
		$action_name = elgg_extract('action_name', $vars);
		if ($action_name !== 'blog/save') {
			return;
		}
		
		// add ability to upload icon
		$vars['enctype'] = 'multipart/form-data';
		
		return $vars;
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
