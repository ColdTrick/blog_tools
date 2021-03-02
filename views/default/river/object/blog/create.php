<?php
/**
 * Blog river view.
 */

$object = $vars['item']->getObjectEntity();

$message = $object->getExcerpt();

if ($object->hasIcon('master')) {
	$icon = elgg_view_entity_icon($object, 'small', [
		'icon_wrapper' => true,
	]);
	
	$message = elgg_format_element('div', ['class' => 'blog-tools-river-item clearfix'], $icon . $message);
}

$vars['message'] = $message;
echo elgg_view('river/elements/layout', $vars);
