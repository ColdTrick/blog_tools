<?php
/**
 * All event handlers are bundled in  this file
 */

/**
 * When a blog is removed also remove it's icons
 *
 * @param string     $event  'delete'
 * @param string     $type   'object'
 * @param ElggObject $object The ElggObject being removed
 *
 * @return void
 */
function blog_tools_delete_handler($event, $type, $object) {
	
	if (elgg_instanceof($object, "object", "blog", "ElggBlog")) {
		blog_tools_remove_blog_icon($object);
	}
}