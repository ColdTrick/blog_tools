<?php

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);

// get widget settings
$count = (int) $widget->blog_count;
if ($count < 1) {
	$count = 8;
}

// listing options
$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'limit' => $count,
	'full_view' => false,
	'pagination' => false,
	'metadata_name_value_pairs' => [],
];

// get view mode
$view_mode = $widget->view_mode;

// backup context and set
switch ($view_mode) {
	case 'simple':
		$options['item_view'] = 'widgets/index_blog/blog/simple';
		break;
	case 'preview':
		// default entity listing
	case 'slider':
		break;
	default:
		$options['item_view'] = 'widgets/index_blog/blog/listing';
		break;
}

// only show published blogs to non admins
if (!elgg_is_admin_logged_in()) {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'status',
		'value' => 'published',
	];
}

// limit to featured blogs?
if ($widget->show_featured === 'yes') {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'featured',
		'value' => '0',
		'operand' => '>',
	];
}

$blog_entities = elgg_get_entities($options);
if (empty($blog_entities)) {
	echo elgg_echo('blog:none');
	return;
}

$blogs = elgg_view_entity_list($blog_entities, $options);

if ($view_mode !== 'slider' || count($blog_entities) === 1) {
	echo $blogs;
	return;
}

// blog container
$container_attr = [
	'class' => 'blog-tools-widget-items-container',
];
echo elgg_format_element('div', $container_attr, $blogs);

// navigator
$navigator_attr = [
	'class' => [
		'elgg-widget-more',
		'blog-tools-widget-items-navigator',
	],
];

$lis = [];
foreach ($blog_entities as $key => $blog) {
	$span = elgg_format_element('span', ['rel' => $blog->guid], ($key + 1));
	
	$li_attr = [];
	if ($key === 0) {
		$li_attr['class'] = 'elgg-state-selected';
	}
	
	$lis[] = elgg_format_element('li', $li_attr, $span);
}
echo elgg_format_element('ul', $navigator_attr, implode(PHP_EOL, $lis));

?>
<script type='text/javascript'>
	require(['widgets/index_blog/slider'], function(Slider) {
		var slider = new Slider();
		slider.init(<?php echo $widget->guid; ?>);
	});
</script>
