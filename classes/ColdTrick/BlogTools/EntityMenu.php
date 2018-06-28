<?php

namespace ColdTrick\BlogTools;

/**
 * Router handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class EntityMenu {
	
	/**
	 * Add some menu items to the entity menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:entity'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!($entity instanceof \ElggBlog) || !elgg_is_admin_logged_in()) {
			return;
		}
		
		// only published blogs
		if ($entity->status === 'draft') {
			return;
		}
		
		$returnvalue = $hook->getValue();
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'blog-feature',
			'text' => elgg_echo('blog_tools:toggle:feature'),
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
			'text' => elgg_echo('blog_tools:toggle:unfeature'),
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
