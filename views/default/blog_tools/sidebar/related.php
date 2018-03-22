<?php
/**
 * Shows a list of blogs related to this blog
 *
 * @uses $vars['entity'] the blog to base the related blogs on
 */

use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\OrderByClause;
use Elgg\Database\Clauses\GroupByClause;

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggBlog) {
	return;
}

if (empty($entity->tags)) {
	return;
}

if (elgg_get_plugin_setting('show_full_related', 'blog_tools') !== 'yes') {
	return;
}
	
$tag_values = $entity->tags;
if (!is_array($tag_values)) {
	$tag_values = [$tag_values];
}

$blogs = elgg_get_entities([
	'type' => 'object',
	'subtype' => 'blog',
	'metadata_name_value_pairs' => [
		'name' => 'tags',
		'value' => $tag_values,
	],
	'selects' => [
		function (QueryBuilder $qb, $main_alias) {
			$join_alias = $qb->joinMetadataTable($main_alias, 'guid', null, 'inner', 'n_table');
			return "count({$join_alias}.id) AS total";
		},
	],
	'wheres' => [
		function (QueryBuilder $qb, $main_alias) use ($entity) {
			return $qb->compare("{$main_alias}.guid", '!=', $entity->guid, ELGG_VALUE_INTEGER);
		},
	],
	'group_by' => [
		new GroupByClause('e.guid'),
	],
	'order_by' => [
		new OrderByClause('total', 'DESC'),
	],
	'limit' => 4,
]);

if (empty($blogs)) {
	return;
}

$title = elgg_echo('blog_tools:view:related');

$content = elgg_view_entity_list($blogs, [
	'count' => count($blogs),
	'pagination' => false,
	'full_view' => false,
	'item_view' => 'object/blog/related',
]);

echo elgg_view_module('aside', $title, $content);
