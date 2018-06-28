<?php
/**
 * Blog river view.
 */

$object = $vars['item']->getObjectEntity();

$excerpt = $entity->getExcerpt();

if ($object->hasIcon('small')) {
	$icon = elgg_view_entity_icon($object, 'small', [
		'icon_wrapper' => true,
	]);
	
	$message = elgg_format_element('div', ['class' => 'blog-tools-river-item clearfix'], $icon . $excerpt);
}

$vars['message'] = $excerpt;
echo elgg_view('river/elements/layout', $vars);
