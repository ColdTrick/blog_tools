<?php

	/**
	 * shows a list of bloga related to this blog
	 *
	 * @uses $vars['entity'] the blog to base the related blogs on
	 * @uses $vars['full_view'] only in full view
	 * @uses get_input('guid') in the sidebar view we don't have $vars['entity']
	 */

	$entity = elgg_extract("entity", $vars);
	$full_view = elgg_extract("full_view", $vars, false);
	
	$sidebar = false;
	
	if (!empty($entity) && !$full_view) {
		return;
	}
	
	if (empty($entity)) {
		$guid = (int) get_input("guid");
		
		$entity = get_entity($guid);
		
		if (!empty($entity) && elgg_instanceof($entity, "object", "blog")) {
			$sidebar = true;
		} else {
			return;
		}
	}

	if (!$entity->tags) {
		return;
	}
	
	$setting = elgg_get_plugin_setting("show_full_related", "blog_tools");
	
	if (!$sidebar && ($setting != "full_view")) {
		return;
	}   elseif ($sidebar && ($setting != "sidebar")) {
		return;
	}
	
	$blogs = blog_tools_get_related_blogs($entity);
	
	if (!empty($blogs)) {
		$content = elgg_view_entity_list($blogs, array(
			"count" => count($blogs),
			"full_view" => false,
			"pagination" => false
		));
		
		if ($sidebar) {
			echo elgg_view_module("aside", "related", $content);
		} else {
			echo "<div class='mts'>";
			echo $content;
			echo "</div>";
		}
	}