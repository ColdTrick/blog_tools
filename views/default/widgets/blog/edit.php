<?php
/**
 * User blog widget edit view
 */

$widget = elgg_extract('entity', $vars);

echo elgg_view('object/widget/edit/num_display', [
	'entity' => $widget,
	'label' => elgg_echo('blog:numbertodisplay'),
	'default' => 4,
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
