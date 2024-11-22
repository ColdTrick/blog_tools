<?php

namespace ColdTrick\BlogTools;

use Elgg\Blog\Forms\PrepareFields;

/**
 * Handle blog form fields
 */
class FieldsHandler {
	
	/**
	 * Change fields for blogs
	 *
	 * @param \Elgg\Event $event 'fields', 'object:blog'
	 *
	 * @return null|array
	 */
	public function __invoke(\Elgg\Event $event): ?array {
		$result = $event->getValue();
		
		foreach ($result as $field) {
			if (elgg_extract('name', $field) !== 'access_id') {
				continue;
			}
			
			if (elgg_get_plugin_setting('advanced_publication', 'blog_tools') === 'yes') {
				$field['#help'] = elgg_echo('blog_tools:edit:access:help:publication');
			} else {
				$field['#help'] = elgg_echo('blog_tools:edit:access:help');
			}
			
			break;
		}
		
		return $result;
	}
}
