<?php

namespace ColdTrick\BlogTools;

class FilterTabs {
	
	/**
	 * Add the featured tab to the blog filter menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:filter'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function addFeatured(\Elgg\Hook $hook) {
		
		if (!elgg_in_context('blog')) {
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'featured',
			'text' => elgg_echo('status:featured'),
			'href' => elgg_generate_url('collection:object:blog:featured'),
			'priority' => 600,
		]);
		
		return $return;
	}
}
