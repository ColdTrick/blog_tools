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
	 * @return void|array
	 */
	public static function preventBlogArchiveSidebar(\Elgg\Event $event) {
		
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return;
		}
		
		$return = $event->getValue();
		$return[ViewsService::OUTPUT_KEY] = '';
		
		return $return;
	}
	
	/**
	 * Prevent double submit of the blog/save form
	 *
	 * @param \Elgg\Event $event 'view_vars', 'input/form'
	 *
	 * @return null|array
	 * @todo remove in Elgg 5.1
	 */
	public static function preventDoubleSubmit(\Elgg\Event $event): ?array {
		$vars = $event->getValue();
		if (elgg_extract('action_name', $vars) !== 'blog/save') {
			return null;
		}
		
		$vars['prevent_double_submit'] = true;
		
		return $vars;
	}
}
