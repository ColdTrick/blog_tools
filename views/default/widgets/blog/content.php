<?php

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);

//get the num of blog entries the user wants to display
$num = (int) $widget->num_display;

//if no number has been set, default to 4
if ($num < 1) {
	$num = 4;
}

$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'limit' => $num,
	'pagination' => false,
	'metadata_name_value_pairs' => [],
];

$owner = $widget->getOwnerEntity();
if ($owner instanceof \ElggUser) {
	$options['owner_guid'] = $owner->guid;
} else {
	$options['container_guid'] = $widget->container_guid;
}

if (!elgg_is_admin_logged_in() && !($widget->owner_guid === elgg_get_logged_in_user_guid())) {
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

$content = elgg_list_entities($options);
if (empty($content)) {
	echo elgg_echo('blog:none');
	return;
}

echo $content;

if ($owner instanceof ElggGroup) {
	$url = elgg_generate_url('collection:object:blog:group', ['guid' => $owner->guid]);
} else {
	$url = elgg_generate_url('collection:object:blog:owner', ['username' => $owner->username]);
}

if (empty($url)) {
	return;
}

$more_link = elgg_view('output/url', [
	'text' => elgg_echo('blog:moreblogs'),
	'href' => $url,
	'is_trusted' => true,
]);
echo elgg_format_element('div', ['class' => 'elgg-widget-more'], $more_link);
