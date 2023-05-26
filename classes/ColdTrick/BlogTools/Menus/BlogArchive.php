<?php

namespace ColdTrick\BlogTools\Menus;

use Elgg\Menu\MenuItems;
use Elgg\Router\Route;

/**
 * Blog Archive Menu callbacks
 */
class BlogArchive {

	/**
	 * Register menu items to the blog archive menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:blog_archive'
	 *
	 * @return null|MenuItems
	 */
	public static function addArchive(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getParam('entity', elgg_get_page_owner_entity());
		if ($event->getParam('page') !== 'tag') {
			return null;
		}
		
		$route = elgg_get_current_route();
		if (!$route instanceof Route) {
			return null;
		}
		
		$tag = elgg_extract('tag', $route->getMatchedParameters());
		if (elgg_is_empty($tag)) {
			return null;
		}
		
		$options = [
			'type' => 'object',
			'subtype' => 'blog',
			'metadata_name_value_pairs' => [
				[
					'name' => 'tags',
					'value' => $tag,
				],
				[
					'name' => 'status',
					'value' => 'published',
				],
			],
		];
		
		$route_name = 'collection:object:blog:tag';
		$route_params = [
			'tag' => $tag,
		];
		
		if ($entity instanceof \ElggEntity) {
			$options['container_guid'] = $entity->guid;
			
			$route_params['container_guid'] = $entity->guid;
		}
		
		$dates = elgg_get_entity_dates($options);
		if (empty($dates)) {
			return null;
		}
		
		$generate_url = function($lower = null, $upper = null) use ($route_name, $route_params) {
			$route_params['lower'] = $lower;
			$route_params['upper'] = $upper;
			
			return elgg_generate_url($route_name, $route_params);
		};
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		$years = [];
		
		$dates = array_reverse($dates);
		foreach ($dates as $date) {
			$timestamplow = mktime(0, 0, 0, substr($date, 4, 2), 1, substr($date, 0, 4));
			$timestamphigh = mktime(0, 0, 0, ((int) substr($date, 4, 2)) + 1, 1, substr($date, 0, 4));
	
			$year = substr($date, 0, 4);
			if (!in_array($year, $years)) {
				$return[] = \ElggMenuItem::factory([
					'name' => $year,
					'text' => $year,
					'href' => false,
					'child_menu' => [
						'display' => 'toggle',
					],
					'priority' => -(int) "{$year}00", // make negative to be sure 2019 is before 2018
				]);
			}
	
			$month = trim(elgg_echo('date:month:' . substr($date, 4, 2), ['']));
	
			$return[] = \ElggMenuItem::factory([
				'name' => $date,
				'text' => $month,
				'href' => $generate_url($timestamplow, $timestamphigh),
				'parent_name' => $year,
				'priority' => -(int) $date, // make negative to be sure March 2019 is before February 2019
			]);
		}
		
		return $return;
	}
}
