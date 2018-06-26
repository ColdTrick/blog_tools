<?php
/**
 * View for blog objects
 *
 * @uses $vars['entity'] ElggBlog entity to show
 */

$full = (bool) elgg_extract('full_view', $vars, false);
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \ElggBlog) {
	return;
}

if ($entity->status && $entity->status !== 'published') {
	$vars['imprint'] = [
		[
			'icon_name' => 'warning',
			'content' => elgg_echo("status:{$entity->status}"),
			'class' => 'elgg-listing-blog-status',
		],
	];
}

$owner = $entity->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'small');

// blog icon
$blog_icon_settings = blog_tools_get_icon_settings($entity, $full);
$blog_icon = '';
if (!empty($blog_icon_settings)) {
	$size = elgg_extract('size', $blog_icon_settings);
	if ($entity->hasIcon($size)) {
		$blog_icon_params = $blog_icon_settings + $vars;
		$blog_icon = elgg_view_entity_icon($entity, $size, $blog_icon_params);
	}
}

if ($full) {
	$body = elgg_view('output/longtext', [
		'value' => $entity->description,
		'class' => 'blog-post',
	]);

	$params = [
		'title' => false,
	];
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', [
		'entity' => $entity,
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $blog_icon . $body,
		'show_navigation' => true,
		'body_params' => [
			'class' => 'clearfix',
		],
	]);
} else {
	// brief view
	$excerpt = $entity->excerpt;
	if (!$excerpt) {
		$excerpt = elgg_get_excerpt($entity->description);
	}

	$params = [
		'content' => elgg_format_element('div', ['class' => 'clearfix'], $blog_icon . $excerpt),
		'icon' => $owner_icon,
	];
	
	// custom imprint
	if (elgg_get_plugin_setting('listing_strapline', 'blog_tools') === 'time') {
		$params['byline'] = false;
		$params['access'] = false;
		$params['tags'] = false;
	}
	
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}
