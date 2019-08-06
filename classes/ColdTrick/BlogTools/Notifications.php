<?php

namespace ColdTrick\BlogTools;

class Notifications {
	
	/**
	 * Returns the 'forced' subscribers
	 *
	 * @param \Elgg\Hook $hook 'get', 'subscriptions'
	 *
	 * @return void|array
	 */
	public static function forceAddSubscriptions(\Elgg\Hook $hook) {
		
		// @todo revisit this
		return;
		
		/* @var $event \Elgg\Notifications\Event */
		$event = $hook->getParam('event');
		if (!$event instanceof \Elgg\Notifications\Event) {
			return;
		}
		
		$action = $event->getAction();
		$object = $event->getObject();
		if (($action !== 'publish') || !$object instanceof \ElggBlog) {
			return;
		}

		if (!$object->force_notifications) {
			return;
		}
		
		$container = $object->getContainerEntity();
		if (!$container instanceof \ElggUser) {
			return;
		}
		
		$users = elgg_get_entities([
			'type' => 'user',
			'limit' => false,
			'batch' => true,
		]);
		
		$result = $hook->getValue();
		foreach ($users as $user) {
			if (array_key_exists($user->guid, $result)) {
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
			
			$result[$user->guid] = $res;
		}
		
		return $result;
	}
}
