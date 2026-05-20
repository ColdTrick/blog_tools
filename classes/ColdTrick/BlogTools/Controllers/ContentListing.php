<?php

namespace ColdTrick\BlogTools\Controllers;

/**
 * List blogs
 */
class ContentListing extends \Elgg\Blog\Controllers\ContentListing {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getListingOptions(string $page, array $options): array {
		$options = parent::getListingOptions($page, $options);
		if (!in_array($page, ['featured', 'tag'])) {
			return $options;
		}
		
		if (!isset($options['metadata_name_value_pairs'])) {
			$options['metadata_name_value_pairs'] = [];
		}
		
		switch ($page) {
			case 'featured':
				$options['metadata_name_value_pairs'][] = [
					'name' => 'featured',
					'value' => 0,
					'operand' => '>',
				];
				break;
			case 'tag':
				$tag = $this->request->getParam('tag');
				
				$options['metadata_name_value_pairs'][] = [
					'name' => 'tags',
					'value' => $tag,
					'case_sensitive' => false,
				];
				
				$container_guid = (int) get_input('container_guid');
				if (!empty($container_guid)) {
					elgg_set_page_owner_guid($container_guid);
					$this->page_owner = elgg_get_page_owner_entity();
					
					$options['container_guid'] = $container_guid;
				}
				break;
		}
		
		
		return $options;
	}
	
	/**
	 * List featured blogs
	 *
	 * @param array $options listing options
	 *
	 * @return string
	 */
	protected function listFeatured(array $options): string {
		elgg_push_collection_breadcrumbs($options['type'], $options['subtype']);
		
		return elgg_view_page('', $this->getPageOptions('featured', [
			'title' => elgg_echo('status:featured'),
			'content' => elgg_view('page/list/all', [
				'options' => $options,
				'page' => 'featured',
			]),
			'filter_value' => 'featured',
		]));
	}
	
	/**
	 * List blogs with a given tag
	 *
	 * @param array $options listing options
	 *
	 * @return string
	 */
	protected function listTag(array $options): string {
		$tag = $this->request->getParam('tag');
		
		elgg_push_collection_breadcrumbs($options['type'], $options['subtype'], $this->page_owner);
		
		return elgg_view_page('', $this->getPageOptions('tag', [
			'title' => elgg_echo('collection:object:blog:tag', [$tag]),
			'content' => elgg_view('page/list/all', [
				'options' => $options,
				'page' => 'tag',
			]),
			'filter_id' => ($this->page_owner instanceof \ElggGroup) ? 'blog/group' : null,
			'filter_value' => 'tag',
		]));
	}
}
