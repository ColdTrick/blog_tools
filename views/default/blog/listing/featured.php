<?php
/**
 * List featured blogs
 *
 * @uses $vars['options'] Options
 */

$defaults = [
	'type' => 'object',
	'subtype' => 'blog',
	'full_view' => false,
	'preload_owners' => true,
	'preload_containers' => true,
	'metadata_name_value_pairs' => [
		[
			'name' => 'status',
			'value' => 'published',
		],
		[
			'name' => 'featured',
			'value' => '0',
			'operand' => '>',
		],
	],
	'no_results' => elgg_echo('blog:none'),
];

$options = (array) elgg_extract('options', $vars, []);
$options = array_merge($defaults, $options);

echo elgg_list_entities($options);
