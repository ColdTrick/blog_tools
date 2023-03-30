<?php
/**
 * List a blog post as a related blog
 *
 * @uses $vars['entity'] the blog post
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggBlog) {
	return;
}

$excerpt_length = (int) elgg_extract('excerpt_size', $vars, 50);

echo elgg_view('object/elements/summary', [
	'entity' => $entity,
	'icon' => true,
	'subtitle' => false,
	'metadata' => false,
	'tags' => false,
	'content' => $entity->getExcerpt($excerpt_length),
]);
