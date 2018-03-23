<?php

if (elgg_get_plugin_setting('force_notification', 'blog_tools', 'no') !== 'yes') {
	return;
}

// forced notifications currently only supported for 'personal' blogs
$page_owner = elgg_get_page_owner_entity();
if (!($page_owner instanceof ElggUser)) {
	return;
}

$entity = get_entity(elgg_extract('guid', $vars));
if ($entity instanceof ElggBlog) {
	$checked = (bool) elgg_extract('force_notifications', $vars, $entity->force_notifications);
} else {
	$checked = (bool) elgg_extract('force_notifications', $vars, false);
}

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('blog_tools:force_notification'),
	'name' => 'force_notifications',
	'value' => 1,
	'checked' => $checked,
	'switch' => true,
]);
