<?php

$status = elgg_view_field([
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
	echo $status;
	return;
}

$entity = get_entity(elgg_extract('guid', $vars));
if ($entity instanceof ElggBlog) {
	$publication_date_value = elgg_extract('publication_date', $vars, $entity->publication_date);
	$expiration_date_value = elgg_extract('expiration_date', $vars, $entity->expiration_date);
} else {
	$publication_date_value = elgg_extract('publication_date', $vars);
	$expiration_date_value = elgg_extract('expiration_date', $vars);
}

if (empty($publication_date_value)) {
	$publication_date_value = '';
}
if (empty($expiration_date_value)) {
	$expiration_date_value = '';
}

$content = $status;

$content .= elgg_view_field([
	'#type' => 'date',
	'#label' => elgg_echo('blog_tools:label:publication_date'),
	'#help' => elgg_echo('blog_tools:publication_date:description'),
	'name' => 'publication_date',
	'value' => $publication_date_value,
]);

$content .= elgg_view_field([
	'#type' => 'date',
	'#label' => elgg_echo('blog_tools:label:expiration_date'),
	'#help' => elgg_echo('blog_tools:expiration_date:description'),
	'name' => 'expiration_date',
	'value' => $expiration_date_value,
]);

echo elgg_view_module('info', elgg_echo('blog_tools:label:publication_options'), $content);
