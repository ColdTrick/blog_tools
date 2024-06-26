<?php

namespace ColdTrick\BlogTools;

use Elgg\ViewsService;

/**
 * Views related callbacks
 */
class Views {
	
	/**
	 * Prevent the blog/sidebar/archives from being draw
	 *
	 * @param \Elgg\Event $event 'view_vars', 'blog/sidebar/archives'
	 *
	 * @return null|array
	 */
	public static function preventBlogArchiveSidebar(\Elgg\Event $event): ?array {
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return null;
		}
		
		$return = $event->getValue();
		$return[ViewsService::OUTPUT_KEY] = '';
		
		return $return;
	}
}
