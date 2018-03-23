<?php
/**
 * Simple view of a blog post for the index widget
 *
 * @uses $vars['entity'] the blog
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggBlog) {
	return;
}

$excerpt = $entity->excerpt;
if (empty($excerpt)) {
	$excerpt = $entity->description;
}

$excerpt = elgg_get_excerpt($excerpt);
if (substr($excerpt, -3) === '...') {
	$more_link = elgg_view('output/url', [
		'text' => elgg_echo('blog_tools:readmore'),
		'href' => $entity->getURL(),
		'is_trusted' => true,
	]);
	
	$excerpt .= " {$more_link}";
}

$params = [
	'entity' => $entity,
	'content' => $excerpt,
	'tags' => false,
	'byline' => false,
	'time' => false,
	'access' => false,
	'show_social_menu' => false,
];
$params + $vars;

echo elgg_view('object/elements/summary', $params);
