<?php

namespace ColdTrick\BlogTools;

/**
 * Widget related callbacks
 */
class Widgets {
	
	/**
	 * Support widget urls for Widget Manager
	 *
	 * @param \Elgg\Event $event 'entity:url', 'object'
	 *
	 * @return null|string
	 */
	public static function widgetUrl(\Elgg\Event $event): ?string {
		if (!empty($event->getValue())) {
			// url already provided
			return null;
		}
		
		$widget = $event->getEntityParam();
		if (!$widget instanceof \ElggWidget || $widget->handler !== 'index_blog') {
			return null;
		}
		
		return elgg_generate_url('collection:object:blog:all');
	}
	
	/**
	 * Add or remove widgets based on the group tool option
	 *
	 * @param \Elgg\Event $event 'group_tool_widgets', 'widget_manager'
	 *
	 * @return void|array
	 */
	public static function groupTools(\Elgg\Event $event) {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return;
		}
		
		$return = $event->getValue();
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
