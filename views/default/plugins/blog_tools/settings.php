<?php

/* @var $plugin Elggplugin */
$plugin = elgg_extract('entity', $vars);

// define possible values
$align_options = [
	'none' => elgg_echo('blog_tools:settings:align:none'),
	'left' => elgg_echo('left'),
	'right' => elgg_echo('right'),
];

$size_options = [
	'tiny' => elgg_echo('blog_tools:settings:size:tiny'),
	'small' => elgg_echo('blog_tools:settings:size:small'),
	'medium' => elgg_echo('blog_tools:settings:size:medium'),
	'large' => elgg_echo('blog_tools:settings:size:large'),
	'master' => elgg_echo('blog_tools:settings:size:master'),
];

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

// icon settings
$settings_image = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:listing:strapline'),
	'name' => 'params[listing_strapline]',
	'options_values' => [
		'default' => elgg_echo('blog_tools:settings:strapline:default'),
		'time' => elgg_echo('blog_tools:settings:strapline:time'),
	],
	'value' => $plugin->listing_strapline,
]);

$settings_image .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:listing:image_align'),
	'name' => 'params[listing_align]',
	'options_values' => $align_options,
	'value' => $plugin->listing_align,
]);

$settings_image .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:listing:image_size'),
	'name' => 'params[listing_size]',
	'options_values' => $size_options,
	'value' => $plugin->listing_size,
]);

$settings_image .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:full:image_align'),
	'name' => 'params[full_align]',
	'options_values' => $align_options,
	'value' => $plugin->full_align,
]);

$settings_image .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:full:image_size'),
	'name' => 'params[full_size]',
	'options_values' => $size_options,
	'value' => $plugin->full_size,
]);

echo elgg_view_module('info', elgg_echo('blog_tools:settings:image'), $settings_image);

// full view options
$settings_full = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:full:show_full_navigation'),
	'name' => 'params[show_full_navigation]',
	'options_values' => $noyes_options,
	'value' => $plugin->show_full_navigation,
]);

$settings_full .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:full:show_full_owner'),
	'name' => 'params[show_full_owner]',
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'optional' => elgg_echo('blog_tools:settings:full:show_full_owner:optional'),
		'yes' => elgg_echo('option:yes'),
	],
	'value' => $plugin->show_full_owner,
]);

$settings_full .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:full:show_full_related'),
	'name' => 'params[show_full_related]',
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'full_view' => elgg_echo('blog_tools:settings:full:show_full_related:full_view'),
		'sidebar' => elgg_echo('blog_tools:settings:full:show_full_related:sidebar'),
	],
	'value' => $plugin->show_full_related,
]);

echo elgg_view_module('info', elgg_echo('blog_tools:settings:full'), $settings_full);

// other settings
$settings_other = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:advanced_publication'),
	'#help' => elgg_echo('blog_tools:settings:advanced_publication:description'),
	'name' => 'params[advanced_publication]',
	'options_values' => $noyes_options,
	'value' => $plugin->advanced_publication,
]);

$settings_other .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('blog_tools:settings:force_notification'),
	'#help' => elgg_echo('blog_tools:settings:force_notification:help'),
	'name' => 'params[force_notification]',
	'options_values' => $noyes_options,
	'value' => $plugin->force_notification,
]);

echo elgg_view_module('info', elgg_echo('blog_tools:settings:other'), $settings_other);
