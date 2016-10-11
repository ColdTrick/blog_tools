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
	 * Return the icon file for a blog icon (if any)
	 *
	 * @param string           $hook        'entity:icon:file'
	 * @param string           $entity_type 'object'
	 * @param \Elgg\EntityIcon $returnvalue the current icon file
	 * @param array            $params      supplied params
	 *
	 * @return void|\Elgg\EntityIcon
	 */
	public static function blogIconFile($hook, $entity_type, $returnvalue, $params) {
		
		if (!($returnvalue instanceof \Elgg\EntityIcon)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggBlog)) {
			return;
		}
		
		$size = strtolower(elgg_extract('size', $params));
		$returnvalue->owner_guid = $entity->getOwnerGUID();
		$returnvalue->setFilename("blogs/{$entity->getGUID()}{$size}.jpg");
		
		return $returnvalue;
	}
}
