<?php
/**
 * Render a blog icon
 *
 * @uses $vars['entity'] the blog entity
 * @uses $vars['size']   the icon size
 * @uses $vars['align']  the icon alignment (right|left|none)
 */

$entity = elgg_extract('entity', $vars);

// do we have a blog
if (!($entity instanceof ElggBlog)) {
	return;
}

$icon_sizes = elgg_get_icon_sizes($entity->getType(), $entity->getSubtype());
$size = elgg_extract('size', $vars);
if (!array_key_exists($size, $icon_sizes)) {
	$size = 'medium';
}

$align = elgg_extract('align', $vars);

// does the blog have an image, or not allowed to render
if (!$entity->hasIcon($size) || $align === 'none') {
	// output a space, otherwise default icon behaviour will be used to output an icon
	echo ' ';
	return;
}

$class = elgg_extract_class($vars, [
	'blog-tools-blog-image',
	"blog-tools-blog-image-{$size}",
]);
if ($align === 'right') {
	$class[] = 'float';
} elseif ($align === 'left') {
	$class[] = 'float-alt';
}

$href = elgg_extract('href', $vars, $entity->getURL());

$title = htmlspecialchars($entity->getDisplayName(), ENT_QUOTES, 'UTF-8', false);

$image_params = [
	'src' => $entity->getIconURL(['size' => $size]),
	'alt' => $title,
	'title' => $title,
	'class' => elgg_extract_class($vars, [],'img_class'),
	'data-highres-url' => $entity->getIconURL(['size' => 'master']),
	'width' => ($size !== 'master') ? $icon_sizes[$size]['w'] : null,
	'height' => ($size !== 'master') ? $icon_sizes[$size]['h'] : null,
];

$content = elgg_view('output/img', $image_params);
if (!empty($href)) {
	$params = [
		'href' => $href,
		'text' => $content,
		'is_trusted' => true,
		'class' => elgg_extract_class($vars, [], 'link_class'),
	];
	
	$content = elgg_view('output/url', $params);
}

if (elgg_extract('icon_wrapper', $vars)) {
	echo elgg_format_element('div', ['class' => $class], $content);
} else {
	echo $content;
}
