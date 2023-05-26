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
		
		/* @Var $returnvalue MenuItems */
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
