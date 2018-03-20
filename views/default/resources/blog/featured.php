<?php
/**
 * list featured blogs
 */

// title button
elgg_register_title_button('blog', 'add', 'object', 'blog');

// breadcrumb
$title = elgg_echo('status:featured');

elgg_push_collection_breadcrumbs('object', 'blog');

// build page elements
$content = elgg_view('blog/listing/featured');

$sidebar = elgg_view('blog/sidebar', [
	'page' => 'featured',
]);

// build page
$body = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
	'filter_value' => 'featured',
]);

// draw page
echo elgg_view_page($title, $body);
