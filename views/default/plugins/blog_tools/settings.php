<?php

/* @var $plugin ElggPlugin */
$plugin = elgg_extract('entity', $vars);

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

// other settings
$settings_other = elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('blog_tools:settings:full:show_full_related'),
	'name' => 'params[show_full_related]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->show_full_related === 'yes',
	'switch' => true,
]);

$settings_other .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('blog_tools:settings:advanced_publication'),
	'#help' => elgg_echo('blog_tools:settings:advanced_publication:description'),
	'name' => 'params[advanced_publication]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->advanced_publication === 'yes',
	'switch' => true,
]);

echo elgg_view_module('info', elgg_echo('blog_tools:settings:other'), $settings_other);
