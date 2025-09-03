<?php
/**
 * User blog widget display view
 */

$widget = elgg_extract('entity', $vars);
if (!$widget instanceof \ElggWidget) {
	return;
}

$num_display = (int) $widget->num_display ?: 4;

$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'limit' => $num_display,
	'pagination' => false,
	'distinct' => false,
	'metadata_name_value_pairs' => [],
	'metadata_case_sensitive' => false,
	'no_results' => true,
	'widget_more' => elgg_view_url($widget->getURL(), elgg_echo('blog:moreblogs')),
];

$owner = $widget->getOwnerEntity();
if ($owner instanceof \ElggUser) {
	$options['owner_guid'] = $owner->guid;
} elseif ($owner instanceof \ElggGroup) {
	$options['container_guid'] = $owner->guid;
}

if (!elgg_is_admin_logged_in() && ($owner->guid !== elgg_get_logged_in_user_guid())) {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'status',
		'value' => 'published',
	];
}

if ($widget->show_featured === 'yes') {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'featured',
		'value' => '0',
		'operand' => '>',
	];
}

echo elgg_list_entities($options);
