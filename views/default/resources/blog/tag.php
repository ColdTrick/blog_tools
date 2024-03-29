<?php
/**
 * List all blogs with a given tag
 *
 * @uses $vars['tag']   the tag to list
 * @uses $vars['lower'] archive lower ts
 * @uses $vars['upper'] archive upper ts
 */

$tag = elgg_extract('tag', $vars);
$lower = elgg_extract('lower', $vars);
$upper = elgg_extract('upper', $vars);

$container_guid = (int) get_input('container_guid');
if (!empty($container_guid)) {
	elgg_set_page_owner_guid($container_guid);
}

$page_owner = elgg_get_page_owner_entity();

elgg_register_title_button('add', 'object', 'blog');

elgg_push_collection_breadcrumbs('object', 'blog', $page_owner ?: null);

echo elgg_view_page(elgg_echo('collection:object:blog:tag', [$tag]), [
	'content' => elgg_view('blog/listing/all', [
		'created_after' => $lower,
		'created_before' => $upper,
		'status' => 'published',
		'options' => [
			'metadata_name_value_pairs' => [
				[
					'name' => 'tags',
					'value' => $tag,
					'case_sensitive' => false,
				],
			],
			'container_guid' => $page_owner ? $page_owner->guid : null,
		],
	]),
	'sidebar' => elgg_view('blog/sidebar', [
		'entity' => $page_owner,
		'page' => 'tag',
	]),
	'filter_id' => ($page_owner instanceof ElggGroup) ? 'blog/group' : null,
	'filter_value' => 'tag',
]);
