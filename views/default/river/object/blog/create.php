<?php
/**
 * Blog river view.
 */

$object = $vars['item']->getObjectEntity();

$excerpt = $object->excerpt ? $object->excerpt : $object->description;
$excerpt = elgg_get_excerpt($excerpt);

$message = $excerpt;
if ($object->hasIcon('small')) {
	$icon = elgg_view_entity_icon($object, 'small', [
		'icon_wrapper' => true,
	]);
	
	$message = elgg_format_element('div', ['class' => 'blog-tools-river-item clearfix'], $icon . $excerpt);
}

$vars['message'] = $message;
echo elgg_view('river/elements/layout', $vars);
