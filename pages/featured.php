<?php
/**
 * list featured blogs
 */

// title button
elgg_register_title_button();

// breadcrumb
$title = elgg_echo('blog_tools:menu:filter:featured');

elgg_push_breadcrumb($title);

// build page elements
$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'full_view' => false,
	'metadata_name_value_pairs' => [
		[
			'name' => 'status',
			'value' => 'published',
		],
		[
			'name' => 'featured',
			'value' => '0',
			'operand' => ' > ',
		],
	],
	'no_results' => elgg_echo('blog:none'),
];
$params['content'] = elgg_list_entities_from_metadata($options);

$params['sidebar'] = elgg_view('blog/sidebar', [
	'page' => null,
]);
$params['filter_context'] = 'featured';

// build page
$body = elgg_view_layout('content', $params);

// draw page
echo elgg_view_page($title, $body);
