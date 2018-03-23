<?php

namespace ColdTrick\BlogTools;

class Notifications {
	
	/**
	 * Returns the 'forced' subscribers
	 *
	 * @param string $hook        the name of the hook
	 * @param string $type        the type of the hook
	 * @param bool   $returnvalue current return value
	 * @param array  $params      supplied params
	 *
	 * @return void|array
	 */
	public static function forceAddSubscriptions($hook, $type, $returnvalue, $params) {
		
		// @todo revisit this
		return;
		
		/* @var $event \Elgg\Notifications\Event */
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
		
		$action = $event->getAction();
		$object = $event->getObject();
		if (($action !== 'publish') || !($object instanceof \ElggBlog)) {
			return;
		}

		if (!$object->force_notifications) {
			return;
		}
		
		$container = $object->getContainerEntity();
		if (!($container instanceof \ElggUser)) {
			return;
		}
		
		$users = elgg_get_entities([
			'type' => 'user',
			'limit' => false,
			'batch' => true,
		]);
		
		foreach ($users as $user) {
			if (array_key_exists($user->guid, $return_value)) {
				continue;
			}
			
			$notification_settings = $user->getNotificationSettings();
			$res = [];
			foreach ($notification_settings as $method => $enabled) {
				if (!$enabled) {
					continue;
				}
				
				$res[] = $method;
			}
			
			if (empty($res)) {
				continue;
			}
			
			$return_value[$user->guid] = $res;
		}
		
		return $return_value;
	}
}
