<?php

namespace ColdTrick\BlogTools\Forms;

/**
 * Prepare the fields for the blog/save form
 */
class PrepareFields {
	
	/**
	 * Prepare the advanced publication options
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'blog/save'
	 *
	 * @return null|array
	 */
	public function __invoke(\Elgg\Event $event): ?array {
		if (elgg_get_plugin_setting('advanced_publication', 'blog_tools') !== 'yes') {
			return null;
		}
		
		$vars = $event->getValue();
		
		$values = [
			'publication_date' => null,
			'publication_time' => null,
		];
		
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \ElggBlog) {
			// load current blog values
			foreach (array_keys($values) as $field) {
				$metadata_name = $field;
				if ($field === 'publication_time') {
					$metadata_name = 'publication';
				}
				
				if (!isset($entity->{$metadata_name})) {
					continue;
				}
				
				$values[$field] = $entity->{$metadata_name};
			}
		}
		
		return array_merge($values, $vars);
	}
}
