<?php

namespace ColdTrick\BlogTools\Menus;

use Elgg\Menu\MenuItems;

/**
 * Entity Menu callbacks
 */
class Entity {
	
	/**
	 * Add some menu items to the entity menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggBlog || !elgg_is_admin_logged_in()) {
			return null;
		}
		
		// only published blogs
		if ($entity->status === 'draft') {
			return null;
		}
		
		/** @var MenuItems $returnvalue */
		$returnvalue = $event->getValue();
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'blog-feature',
			'icon' => 'arrow-up',
			'text' => elgg_echo('feature'),
			'href' => elgg_generate_action_url('blog_tools/toggle_featured', [
				'guid' => $entity->guid,
			]),
			'item_class' => empty($entity->featured) ? '' : 'hidden',
			'priority' => 175,
			'data-toggle' => 'blog-unfeature',
			'parent_name' => 'admin',
		]);
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'blog-unfeature',
			'icon' => 'arrow-down',
			'text' => elgg_echo('unfeature'),
			'href' => elgg_generate_action_url('blog_tools/toggle_featured', [
				'guid' => $entity->guid,
			]),
			'item_class' => empty($entity->featured) ? 'hidden' : '',
			'priority' => 176,
			'data-toggle' => 'blog-feature',
			'parent_name' => 'admin',
		]);
		
		return $returnvalue;
	}
}
