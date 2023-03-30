<?php
/**
 * Listing view of a blog post for the index widget
 *
 * @uses $vars['entity'] the blog
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggBlog) {
	return;
}

$vars['icon'] = true;

echo elgg_view('object/elements/summary', $vars);
