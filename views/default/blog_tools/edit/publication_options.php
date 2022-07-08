<?php

echo elgg_view_field([
	'#label' => elgg_echo('status'),
	'#type' => 'select',
	'name' => 'status',
	'id' => 'blog_status',
	'value' => elgg_extract('status', $vars),
	'options_values' => [
		'draft' => elgg_echo('status:draft'),
		'published' => elgg_echo('status:published'),
	],
]);

if (elgg_get_plugin_setting('advanced_publication', 'blog_tools') !== 'yes') {
	return;
}

$entity = get_entity(elgg_extract('guid', $vars));
if ($entity instanceof ElggBlog) {
	$publication_date_value = elgg_extract('publication_date', $vars, $entity->publication_date);
	$publication_time_value = elgg_extract('publication_time', $vars, $entity->publication);
} else {
	$publication_date_value = elgg_extract('publication_date', $vars);
	$publication_time_value = elgg_extract('publication_time', $vars);
}

echo elgg_view_field([
	'#type' => 'fieldset',
	'fields' => [
		[
			'#type' => 'date',
			'#label' => elgg_echo('blog_tools:label:publication_date'),
			'#help' => elgg_echo('blog_tools:publication_date:description'),
			'name' => 'publication_date',
			'value' => $publication_date_value,
		],
		[
			'#type' => 'time',
			'#label' => elgg_echo('blog_tools:label:publication_time'),
			'#help' => elgg_echo('blog_tools:publication_time:description'),
			'name' => 'publication_time',
			'value' => $publication_time_value,
			'timestamp' => true,
		],
	],
	'align' => 'horizontal',
]);
