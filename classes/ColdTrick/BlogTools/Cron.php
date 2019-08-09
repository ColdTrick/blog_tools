<?php

namespace ColdTrick\BlogTools;

/**
 * Cron handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class Cron {
	
	/**
	 * Publish blogs based on advanced publication options
	 *
	 * @param \Elgg\Hook $hook 'cron', 'fifteenmin'
	 *
	 * @return void
	 */
	public static function publication(\Elgg\Hook $hook) {
		
		// only do if this is configured
		if (elgg_get_plugin_setting('advanced_publication', 'blog_tools') !== 'yes') {
			return;
		}
		
		echo 'Starting BlogTools advanced publications' . PHP_EOL;
		elgg_log('Starting BlogTools advanced publications', 'NOTICE');
		
		$time = (int) $hook->getParam('time', time());
		
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
		
		$publish_options = [
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => false,
			'batch' => true,
			'metadata_name_value_pairs' => [
				[
					'name' => 'status',
					'value' => 'draft',
				],
				[
					'name' => 'publication',
					'value' => $time,
					'operand' => '=',
					'type' => ELGG_VALUE_INTEGER,
				],
			],
		];
		
		// backup logged in user
		$session = elgg_get_session();
		$backup_user = $session->getLoggedInUser();
		
		// get unpublished blogs that need to be published
		$entities = elgg_get_entities($publish_options);
		/* @var $entity \ElggBlog */
		foreach ($entities as $entity) {
			/* @var $owner \ElggUser */
			$owner = $entity->getOwnerEntity();
			
			// fake logged in user, for notifications
			$session->setLoggedInUser($owner);
			
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
			$session->setLoggedInUser($backup_user);
		} else {
			$session->removeLoggedInUser();
		}
	}
}
