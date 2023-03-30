<?php
/**
 * list featured blogs
 */

elgg_register_title_button('add', 'object', 'blog');

elgg_push_collection_breadcrumbs('object', 'blog');

echo elgg_view_page(elgg_echo('status:featured'), [
	'content' => elgg_view('blog/listing/all', [
		'options' => [
			'metadata_name_value_pairs' => [
				[
					'name' => 'featured',
					'value' => '0',
					'operand' => '>',
				],
			],
		],
		'status' => 'published',
	]),
	'sidebar' => elgg_view('blog/sidebar', ['page' => 'featured']),
	'filter_value' => 'featured',
]);
