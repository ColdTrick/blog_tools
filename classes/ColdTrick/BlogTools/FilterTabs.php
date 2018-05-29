<?php

namespace ColdTrick\BlogTools;

use Elgg\Menu\UnpreparedMenu;

class FilterTabs {
	
	/**
	 * Add the featured tab to the blog filter menu
	 *
	 * @param \Elgg\Hook $hook 'filter_tabs', 'blog'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function addFeatured(\Elgg\Hook $hook) {
		
		if (!elgg_in_context('blog')) {
			return;
		}
		
		if (!(bool) elgg_get_plugin_setting('featured_menu', 'blog_tools')) {
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
	
	/**
	 * Add the archive tab to the blog filter menu
	 *
	 * @param \Elgg\Hook $hook 'filter_tabs', 'blog'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function addArchive(\Elgg\Hook $hook) {
		
		if (!elgg_in_context('blog')) {
			return;
		}
		
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return;
		}
		
		$selected = $hook->getParam('selected');
		if (!in_array($selected, ['all', 'mine', 'none'])) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		$archive = elgg()->menus->getUnpreparedMenu('blog_archive', [
			'page' => $selected === 'all' ? 'all': 'owner',
			'entity' => $page_owner,
		]);
		if (empty($archive) || !$archive instanceof UnpreparedMenu) {
			// no archive to show
			return;
		}
		$items = $archive->getItems();
		if (!$items->count()) {
			// no archive to show
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'collection:object:blog:group:archive',
			'text' => elgg_echo('blog:archives'),
			'href' => false,
			'child_menu' => [
				'display' => 'dropdown',
				'data-position' => json_encode([
					'my' => 'left top',
					'at' => 'left bottom+8px',
					'collision' => 'fit fit',
				]),
			],
			'priority' => 600,
		]);
		
		/* @var $menu_item \ElggMenuItem */
		foreach ($items as $menu_item) {
			if (!$menu_item->getParentName()) {
				// years need a parent
				$menu_item->setParentName('collection:object:blog:group:archive');
			}
			
			$return[] = $menu_item;
		}
		
		return $return;
	}
	
	/**
	 * Add tabs to the group blog listing
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:filter:blog/group'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupTabs(\Elgg\Hook $hook) {
		
		if (!elgg_in_context('blog')) {
			return;
		}
		
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		if (!$page_owner instanceof \ElggGroup) {
			return;
		}
		
		$return = $hook->getValue();
		
		$archive = elgg()->menus->getUnpreparedMenu('blog_archive', [
			'page' => 'group',
			'entity' => $page_owner,
		]);
		if (empty($archive) || !$archive instanceof UnpreparedMenu) {
			// no archive to show
			return;
		}
		$items = $archive->getItems();
		if (!$items->count()) {
			// no archive to show
			return;
		}
		
		// add link to all blogs
		$return[] = \ElggMenuItem::factory([
			'name' => 'collection:object:blog:group',
			'text' => elgg_echo('collection:object:blog'),
			'href' => elgg_generate_url('collection:object:blog:group', [
				'guid' => $page_owner->guid,
			]),
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'collection:object:blog:group:archive',
			'text' => elgg_echo('blog:archives'),
			'href' => false,
			'child_menu' => [
				'display' => 'dropdown',
				'data-position' => json_encode([
					'my' => 'left top',
					'at' => 'left bottom+8px',
					'collision' => 'fit fit',
				]),
			],
		]);
		
		/* @var $menu_item \ElggMenuItem */
		foreach ($items as $menu_item) {
			if (!$menu_item->getParentName()) {
				// years need a parent
				$menu_item->setParentName('collection:object:blog:group:archive');
			}
			
			$return[] = $menu_item;
		}
		
		return $return;
	}
}
