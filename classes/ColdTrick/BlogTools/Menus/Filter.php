<?php

namespace ColdTrick\BlogTools\Menus;

use Elgg\Menu\MenuItems;
use Elgg\Menu\UnpreparedMenu;

/**
 * Filter Menu callbacks
 */
class Filter {
	
	/**
	 * Add the featured tab to the blog filter menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:filter:filter'
	 *
	 * @return null|MenuItems
	 */
	public static function addFeatured(\Elgg\Event $event): ?MenuItems {
		if (!elgg_in_context('blog')) {
			return null;
		}
		
		if (!(bool) elgg_get_plugin_setting('featured_menu', 'blog_tools')) {
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		
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
	 * @param \Elgg\Event $event 'register', 'menu:filter:filter'
	 *
	 * @return null|MenuItems
	 */
	public static function addArchive(\Elgg\Event $event): ?MenuItems {
		if (!elgg_in_context('blog')) {
			return null;
		}
		
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return null;
		}
		
		$selected = $event->getParam('filter_value', 'all');
		if ($selected === 'none') {
			// selected is passed as 'none' on owner/friends not current user
			$route = elgg_get_current_route();
			if (!empty($route) && $route->getName() === 'collection:object:blog:friends') {
				$selected = 'friends';
			} else {
				$selected = 'owner';
			}
		} elseif ($selected === 'mine') {
			$selected = 'owner';
		}
		
		$page_owner = elgg_get_page_owner_entity();
		$archive = elgg()->menus->getUnpreparedMenu('blog_archive', [
			'page' => $selected,
			'entity' => $page_owner,
		]);
		
		$items = $archive->getItems();
		if (!$items->count()) {
			// no archive to show
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'collection:object:blog:group:archive',
			'text' => elgg_echo('blog:archives'),
			'href' => false,
			'child_menu' => [
				'display' => 'dropdown',
				'data-position' => json_encode([
					'my' => 'right top',
					'at' => 'right bottom+8px',
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
	 * @param \Elgg\Event $event 'register', 'menu:filter:blog/group'
	 *
	 * @return null|MenuItems
	 */
	public static function groupTabs(\Elgg\Event $event): ?MenuItems {
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return null;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		if (!$page_owner instanceof \ElggGroup) {
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		
		$archive = elgg()->menus->getUnpreparedMenu('blog_archive', [
			'page' => $event->getParam('filter_value', 'group'),
			'entity' => $page_owner,
		]);
		
		$items = $archive->getItems();
		if (!$items->count()) {
			// no archive to show
			return null;
		}
		
		// add link to all blogs
		$return[] = \ElggMenuItem::factory([
			'name' => 'collection:object:blog:group',
			'text' => elgg_echo('collection:object:blog'),
			'href' => elgg_generate_url('collection:object:blog:group', [
				'guid' => $page_owner->guid,
			]),
			'priority' => 200,
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'collection:object:blog:group:archive',
			'text' => elgg_echo('blog:archives'),
			'href' => false,
			'child_menu' => [
				'display' => 'dropdown',
				'data-position' => json_encode([
					'my' => 'right top',
					'at' => 'right bottom+8px',
					'collision' => 'fit fit',
				]),
			],
			'priority' => 500,
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
