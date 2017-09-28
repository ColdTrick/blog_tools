<?php
/**
 * All helper functions can be found here
 *
 */

/**
 * Check a plugin setting for the allowed use of advanced publication options
 *
 * @return bool
 */
function blog_tools_use_advanced_publication_options() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = false;
	
	$setting = elgg_get_plugin_setting('advanced_publication', 'blog_tools');
	if ($setting === 'yes') {
		$result = true;
	}
	
	return $result;
}

/**
 * Get related blogs to this blog
 *
 * @param ElggBlog $entity the blog to relate to
 * @param int      $limit  number of blogs to return
 *
 * @return false|ElggBlog[]
 */
function blog_tools_get_related_blogs(ElggBlog $entity, $limit = 4) {
	
	$limit = sanitise_int($limit, false);
	
	if (!($entity instanceof ElggBlog)) {
		return false;
	}
	
	// transform to values
	$tag_values = $entity->tags;
	if (empty($tag_values)) {
		return false;
	}
	
	if (!is_array($tag_values)) {
		$tag_values = [$tag_values];
	}
	
	// find blogs with these metadatavalues
	$options = [
		'type' => 'object',
		'subtype' => 'blog',
		'metadata_name' => 'tags',
		'metadata_values' => $tag_values,
		'wheres' => [
			"(e.guid <> {$entity->getGUID()})",
		],
		'group_by' => 'e.guid',
		'order_by' => 'count(msn.id) DESC',
		'limit' => $limit,
	];
	
	return elgg_get_entities_from_metadata($options);
}
