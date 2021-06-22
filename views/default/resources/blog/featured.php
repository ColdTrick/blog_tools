<?php
/**
 * list featured blogs
 */

// title button
elgg_register_title_button('blog', 'add', 'object', 'blog');

// breadcrumb
elgg_push_collection_breadcrumbs('object', 'blog');

// build page elements
$content = elgg_view('blog/listing/featured');

$sidebar = elgg_view('blog/sidebar', [
	'page' => 'featured',
]);

// draw page
echo elgg_view_page(elgg_echo('status:featured'), [
	'content' => $content,
	'sidebar' => $sidebar,
	'filter_value' => 'featured',
]);
