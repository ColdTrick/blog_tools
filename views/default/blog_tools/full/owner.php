<?php
/**
 * show some information about the blog owner
 *
 * @uses $vars['entity'] to get the owner of the blog
 * @users $vars['full_view'] only when in full view of the blog
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggBlog) {
	return;
}

$setting = elgg_get_plugin_setting('show_full_owner', 'blog_tools');

if (($setting === 'optional') && ($entity->show_owner !== 'yes')) {
	return;
} elseif (($setting !== 'yes') && ($setting !== 'optional')) {
	return;
}

$owner = $entity->getOwnerEntity();
if (!$owner instanceof ElggUser) {
	return;
}

echo elgg_view_message('notice', elgg_view_entity($owner, ['full_view' => false]), ['title' => false, 'class' => 'mtm']);
