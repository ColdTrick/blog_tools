<?php
/**
 * Extend on blog/save form
 *
 * @uses $vars['guid'] editing or new
 */

$entity = get_entity(elgg_extract('guid', $vars));

// show owner
$show_owner_setting = elgg_get_plugin_setting('show_full_owner', 'blog_tools', 'no');

if (!$entity instanceof ElggBlog) {
	$show_owner_value = elgg_extract('show_owner', $vars, $show_owner_setting);
} else {
	$show_owner_value = elgg_extract('show_owner', $vars, $entity->show_owner);
}

if ($show_owner_setting === 'optional') {
	echo elgg_view_field([
		'#type' => 'checkbox',
		'#label' => elgg_echo('blog_tools:label:show_owner'),
		'name' => 'show_owner',
		'default' => 'no',
		'value' => 'yes',
		'checked' => $show_owner_value === 'yes',
		'switch' => true,
	]);
} else {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'show_owner',
		'value' => $show_owner_value,
	]);
}
