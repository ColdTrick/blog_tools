<?php

namespace ColdTrick\BlogTools\Controllers;

use Elgg\Values;

/**
 * Extend the blog edit action with advanced publication options
 */
class EditAction extends \Elgg\Blog\Controllers\EditAction {
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(array $skip_field_names = []): void {
		if (elgg_get_plugin_setting('advanced_publication', 'blog_tools') !== 'yes') {
			parent::execute($skip_field_names);
			return;
		}
		
		$publication_date = $this->request->getParam('publication_date');
		$publication_time = $this->request->getParam('publication_time');
		$publication = null;
		
		if (!empty($publication_date)) {
			$date = Values::normalizeTime($publication_date);
			if (!empty($publication_time)) {
				$date->modify("+{$publication_time} seconds");
			}
			
			$publication = $date->getTimestamp();
			
			if ($publication > time()) {
				$this->request->setParam('preview', true);
			}
		}
		
		parent::execute($skip_field_names);
		
		$this->entity->publication_date = $publication_date;
		$this->entity->publication_time = $publication_time;
		$this->entity->publication = $publication;
	}
}
