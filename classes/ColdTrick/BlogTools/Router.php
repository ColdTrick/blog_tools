<?php

namespace ColdTrick\BlogTools;

/**
 * Router handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class Router {
	
	/**
	 * Listen to the blog page handler, to takeover some pages
	 *
	 * @param string $hook         'route'
	 * @param string $type         'blog'
	 * @param array  $return_value the current page_handler params
	 * @param null   $params       null
	 *
	 * @return void|false
	 */
	public static function blog($hook, $type, $return_value, $params) {
		return;
		$page = elgg_extract('segments', $return_value);
		if (empty($page)) {
			return;
		}
		
		switch ($page[0]) {
			case 'read': // Elgg 1.7 compatibility
			case 'view':
				set_input('guid', $page[1]); // to be used in the blog_tools/full/related view
				break;
		}
	}
}
