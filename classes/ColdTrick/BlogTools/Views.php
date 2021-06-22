<?php

namespace ColdTrick\BlogTools;

use Elgg\ViewsService;

class Views {
	
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
