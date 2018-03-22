<?php
/**
 * View for blog objects
 *
 * @package Blog
 */

$full = (bool) elgg_extract('full_view', $vars, false);
$blog = elgg_extract('entity', $vars, false);

if (!($blog instanceof \ElggBlog)) {
	return;
}

$owner = $blog->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'small');

// blog icon
$blog_icon_settings = blog_tools_get_icon_settings($blog, $full);
$blog_icon = '';
if (!empty($blog_icon_settings)) {
	$size = elgg_extract('size', $blog_icon_settings);
	if ($blog->hasIcon($size)) {
		$blog_icon_params = $blog_icon_settings + $vars;
		$blog_icon = elgg_view_entity_icon($blog, $size, $blog_icon_params);
	}
}

if ($full) {
	$body = elgg_view('output/longtext', [
		'value' => $blog->description,
		'class' => 'blog-post',
	]);

	$params = [
		'entity' => $blog,
		'title' => false,
	];
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', [
		'entity' => $blog,
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
	$excerpt = $blog->excerpt;
	if (!$excerpt) {
		$excerpt = elgg_get_excerpt($blog->description);
	}

	$params = [
		'entity' => $blog,
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
