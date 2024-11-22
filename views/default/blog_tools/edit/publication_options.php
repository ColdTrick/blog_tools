<?php
/**
 * Extend the blog/save form with advanced publication options
 */

if (elgg_get_plugin_setting('advanced_publication', 'blog_tools') !== 'yes') {
	return;
}

echo elgg_view_field([
	'#type' => 'fieldset',
	'fields' => [
		[
			'#type' => 'date',
			'#label' => elgg_echo('blog_tools:label:publication_date'),
			'#help' => elgg_echo('blog_tools:publication_date:description'),
			'name' => 'publication_date',
			'value' => elgg_extract('publication_date', $vars),
		],
		[
			'#type' => 'time',
			'#label' => elgg_echo('blog_tools:label:publication_time'),
			'#help' => elgg_echo('blog_tools:publication_time:description'),
			'name' => 'publication_time',
			'value' => elgg_extract('publication_time', $vars),
			'timestamp' => true,
		],
	],
	'align' => 'horizontal',
]);
