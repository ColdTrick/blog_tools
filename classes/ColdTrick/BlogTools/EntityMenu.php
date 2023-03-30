<?php

namespace ColdTrick\BlogTools;

/**
 * Entity Menu callbacks
 */
class EntityMenu {
	
	/**
	 * Add some menu items to the entity menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register(\Elgg\Event $event) {
		
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggBlog || !elgg_is_admin_logged_in()) {
			return;
		}
		
		// only published blogs
		if ($entity->status === 'draft') {
			return;
		}
		
		$returnvalue = $event->getValue();
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'blog-feature',
			'text' => elgg_echo('feature'),
			'icon' => 'arrow-up',
			'href' => elgg_generate_action_url('blog_tools/toggle_featured', [
				'guid' => $entity->guid,
			]),
			'item_class' => empty($entity->featured) ? '' : 'hidden',
			'priority' => 175,
			'data-toggle' => 'blog-unfeature',
		]);
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'blog-unfeature',
			'text' => elgg_echo('unfeature'),
			'icon' => 'arrow-down',
			'href' => elgg_generate_action_url('blog_tools/toggle_featured', [
				'guid' => $entity->guid,
			]),
			'item_class' => empty($entity->featured) ? 'hidden' : '',
			'priority' => 176,
			'data-toggle' => 'blog-feature',
		]);
		
		return $returnvalue;
	}
}
