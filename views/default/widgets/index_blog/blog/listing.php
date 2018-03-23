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

$params = [
	'entity' => $entity,
];
$params + $vars;

echo elgg_view('object/elements/summary', $params);
