<?php
/**
 * List a blog post as a related blog
 *
 * @uses $vars['entity'] the blog post
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggBlog) {
	return;
}

$icon_size = elgg_extract('icon_size', $vars, 'small');
$excerpt_length = (int) elgg_extract('excerpt_size', $vars, 50);

if ($entity->hasIcon($icon_size)) {
	$icon = elgg_view_entity_icon($entity, $icon_size);
} else {
	$icon = elgg_view_entity_icon($entity->getOwnerEntity(), $icon_size, ['use_hover' => false]);
}

$excerpt = $entity->excerpt;
if (empty($excerpt)) {
	$excerpt = $entity->description;
}

$excerpt = elgg_get_excerpt($excerpt, $excerpt_length);

echo elgg_view('object/elements/summary', [
	'entity' => $entity,
	'icon' => $icon,
	'subtitle' => false,
	'metadata' => false,
	'tags' => false,
	'content' => $excerpt,
]);
