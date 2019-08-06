<?php

namespace ColdTrick\BlogTools;

/**
 * Widget releated functions
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class Widgets {
	
	/**
	 * Support widget urls for Widget Manager
	 *
	 * @param \Elgg\Hook $hook 'entity:url', 'object'
	 *
	 * @return void|string
	 */
	public static function widgetUrl(\Elgg\Hook $hook) {
		
		if (!empty($hook->getValue())) {
			return;
		}
		
		$widget = $hook->getEntityParam();
		if (!$widget instanceof \ElggWidget) {
			return;
		}
		
		switch ($widget->handler) {
			case 'index_blog':
				return elgg_generate_url('collection:object:blog:all');
			
			case 'blog':
				$owner = $widget->getOwnerEntity();
				if ($owner instanceof \ElggUser) {
					return elgg_generate_url('collection:object:blog:owner', [
						'username' => $owner->username,
					]);
				} elseif ($owner instanceof \ElggGroup) {
					return elgg_generate_url('collection:object:blog:group', [
						'guid' => $owner->guid,
					]);
				}
				break;
		}
	}
	
	/**
	 * Add or remove widgets based on the group tool option
	 *
	 * @param \Elgg\Hook $hook 'group_tool_widgets', 'widget_manager'
	 *
	 * @return void|array
	 */
	public static function groupTools(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return;
		}
		
		$return = $hook->getValue();
		if (!is_array($return)) {
			// someone has other ideas
			return;
		}
		
		// check different group tools for which we supply widgets
		if ($entity->isToolEnabled('blog')) {
			$return['enable'][] = 'blog';
		} else {
			$return['disable'][] = 'blog';
		}
		
		return $return;
	}
}
