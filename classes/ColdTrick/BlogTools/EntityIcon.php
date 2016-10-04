<?php

namespace ColdTrick\BlogTools;

/**
 * Router handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class EntityIcon {
	
	/**
	 * Return the url for a blog icon (if any)
	 *
	 * @param string $hook        'entity:icon:url'
	 * @param string $entity_type 'object'
	 * @param string $returnvalue the current icon url
	 * @param array  $params      supplied params
	 *
	 * @return void|string
	 */
	public static function blogIcon($hook, $entity_type, $returnvalue, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggBlog)) {
			return;
		}
		
		$iconsizes = (array) elgg_get_icon_sizes('object', 'blog');
		$size = strtolower(elgg_extract('size', $params));
		if (!array_key_exists($size, $iconsizes)) {
			$size = 'medium';
		}
			
		$icontime = (int) $entity->icontime;
		if (!$icontime) {
			return;
		}
		
		$url = elgg_http_add_url_query_elements('mod/blog_tools/pages/thumbnail.php', [
			'guid' => $entity->getOwnerGUID(),
			'blog_guid' => $entity->getGUID(),
			'size' => $size,
			'icontime' => $icontime,
		]);
		
		return elgg_normalize_url($url);
	}
}
