<?php

namespace ColdTrick\BlogTools;

/**
 * Cron callbacks
 */
class Cron {
	
	/**
	 * Publish blogs based on advanced publication options
	 *
	 * @param \Elgg\Event $event 'cron', 'fifteenmin'
	 *
	 * @return void
	 */
	public static function publication(\Elgg\Event $event) {
		// only do if this is configured
		if (elgg_get_plugin_setting('advanced_publication', 'blog_tools') !== 'yes') {
			return;
		}
		
		echo 'Starting BlogTools advanced publications' . PHP_EOL;
		elgg_log('Starting BlogTools advanced publications', 'NOTICE');
		
		$time = (int) $event->getParam('time', time());
		
		// ignore access
		elgg_call(ELGG_IGNORE_ACCESS, function() use ($time) {
			self::publishBlogs($time);
		});
		
		echo 'Done with BlogTools advanced publications' . PHP_EOL;
		elgg_log('Done with BlogTools advanced publications', 'NOTICE');
	}
	
	/**
	 * Publish blogs based on advanced publication settings
	 *
	 * @param int $time the timestamp the entity was published
	 *
	 * @return void
	 */
	protected static function publishBlogs($time) {
		
		// adjust for time drift of the cron start
		// eg. CRON started @ 11:00:05
		$time_min = $time - 60; // - 1 minute
		$time_max = $time + 60; // + 1 minute
		
		$publish_options = [
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
			'metadata_name_value_pairs' => [
				[
					'name' => 'status',
					'value' => 'draft',
				],
				[
					'name' => 'publication',
					'value' => $time_min,
					'operand' => '>=',
					'type' => ELGG_VALUE_INTEGER,
				],
				[
					'name' => 'publication',
					'value' => $time_max,
					'operand' => '<=',
					'type' => ELGG_VALUE_INTEGER,
				],
			],
		];
		
		// backup logged in user
		$session_manager = elgg()->session_manager;
		$backup_user = $session_manager->getLoggedInUser();
		
		// get unpublished blogs that need to be published
		$entities = elgg_get_entities($publish_options);
		/* @var $entity \ElggBlog */
		foreach ($entities as $entity) {
			/* @var $owner \ElggUser */
			$owner = $entity->getOwnerEntity();
			
			// fake logged in user, for notifications
			$session_manager->setLoggedInUser($owner);
			
			// add river item
			elgg_create_river_item([
				'view' => 'river/object/blog/create',
				'action_type' => 'create',
				'subject_guid' => $owner->guid,
				'object_guid' => $entity->guid,
			]);
			
			// set correct time created
			$entity->time_created = $time;
				
			// publish blog
			$entity->status = 'published';
				
			// revert access
			$entity->access_id = $entity->future_access;
			unset($entity->future_access);
			
			// Prevent double notification issues with Advanded Notifications plugin
			unset($entity->advanced_notifications_delayed_action);
			
			// save everything
			$entity->save();
			
			// send notifications when post published
			elgg_trigger_event('publish', 'object', $entity);
				
			// notify owner
			notify_user($owner->guid,
				elgg_get_site_entity()->guid,
				elgg_echo('blog_tools:notify:publish:subject', [], $owner->getLanguage()),
				elgg_echo('blog_tools:notify:publish:message', [
					$entity->getDisplayName(),
					$entity->getURL(),
				], $owner->getLanguage())
			);
		}
		
		// restore logged in user
		if ($backup_user instanceof \ElggUser) {
			$session_manager->setLoggedInUser($backup_user);
		} else {
			$session_manager->removeLoggedInUser();
		}
	}
}
