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
	'container_guid' => $widget->container_guid,
	'limit' => $num,
	'full_view' => false,
	'pagination' => false,
	'metadata_name_value_pairs' => [],
];

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

$owner = $widget->getOwnerEntity();
if ($owner instanceof ElggGroup) {
	$more_link = elgg_view('output/url', [
		'href' => elgg_generate_url('collection:object:blog:group', [
			'guid' => $owner->guid,
		]),
		'text' => elgg_echo('blog:moreblogs'),
		'is_trusted' => true,
	]);
} else {
	$more_link = elgg_view('output/url', [
		'href' => elgg_generate_url('collection:object:blog:owner', [
			'username' => $owner->username,
		]),
		'text' => elgg_echo('blog:moreblogs'),
		'is_trusted' => true,
	]);
}

echo elgg_format_element('div', ['class' => 'elgg-widget-more'], $more_link);
