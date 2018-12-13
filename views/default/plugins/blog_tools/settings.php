<?php

/* @var $plugin ElggPlugin */
$plugin = elgg_extract('entity', $vars);

// define possible values
$align_options = [
	'none' => elgg_echo('blog_tools:settings:align:none'),
	'left' => elgg_echo('left'),
	'right' => elgg_echo('right'),
];

$icon_sizes = elgg_get_icon_sizes('object', 'blog');
$size_options = [];
foreach ($icon_sizes as $size => $config) {
	$label = $size;
	if (elgg_language_key_exists("icon:size:{$size}")) {
		$label = elgg_echo("icon:size:{$size}");
	}
	
	$width = (int) elgg_extract('w', $config);
	$height = (int) elgg_extract('h', $config);
	
	$label .= " ({$width} x {$height})";
	
	$size_options[$size] = $label;
}

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

// menu settings
$menu = elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('blog_tools:settings:featured_menu'),
	'#help' => elgg_echo('blog_tools:settings:featured_menu:help'),
	'name' => 'params[featured_menu]',
	'value' => 1,
	'checked' => (bool) $plugin->featured_menu,
	'switch' => true,
]);

$menu .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('blog_tools:settings:archive_menu'),
	'#help' => elgg_echo('blog_tools:settings:archive_menu:help'),
	'name' => 'params[archive_menu]',
	'value' => 1,
	'checked' => (bool) $plugin->archive_menu,
	'switch' => true,
]);

echo elgg_view_module('info', elgg_echo('blog_tools:settings:menu'), $menu);

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
	'#type' => 'checkbox',
	'#label' => elgg_echo('blog_tools:settings:full:show_full_related'),
	'name' => 'params[show_full_related]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->show_full_related === 'yes',
	'switch' => true,
]);

echo elgg_view_module('info', elgg_echo('blog_tools:settings:full'), $settings_full);

// other settings
// @todo revisit this
// $settings_other = elgg_view_field([
// 	'#type' => 'select',
// 	'#label' => elgg_echo('blog_tools:settings:advanced_publication'),
// 	'#help' => elgg_echo('blog_tools:settings:advanced_publication:description'),
// 	'name' => 'params[advanced_publication]',
// 	'options_values' => $noyes_options,
// 	'value' => $plugin->advanced_publication,
// ]);

// $settings_other .= elgg_view_field([
// 	'#type' => 'select',
// 	'#label' => elgg_echo('blog_tools:settings:force_notification'),
// 	'#help' => elgg_echo('blog_tools:settings:force_notification:help'),
// 	'name' => 'params[force_notification]',
// 	'options_values' => $noyes_options,
// 	'value' => $plugin->force_notification,
// ]);

// echo elgg_view_module('info', elgg_echo('blog_tools:settings:other'), $settings_other);
