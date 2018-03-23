<?php

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);

$count = (int) $widget->blog_count;
if ($count < 1) {
	$count = 8;
}

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('blog:numbertodisplay'),
	'name' => 'params[blog_count]',
	'value' => $count,
	'min' => '1',
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:widgets:index_blog:view_mode'),
	'name' => 'params[view_mode]',
	'options_values' => [
		'list' => elgg_echo('blog_tools:widgets:index_blog:view_mode:list'),
		'preview' => elgg_echo('blog_tools:widgets:index_blog:view_mode:preview'),
		'slider' => elgg_echo('blog_tools:widgets:index_blog:view_mode:slider'),
		'simple' => elgg_echo('blog_tools:widgets:index_blog:view_mode:simple'),
	],
	'value' => $widget->view_mode,
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('blog_tools:widget:featured'),
	'name' => 'params[show_featured]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $widget->show_featured === 'yes',
	'switch' => true,
]);
