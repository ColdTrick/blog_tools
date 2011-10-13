<?php

	/**
	 * fancybox view, so no page draw
	 */

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	
	if(!empty($guid)){
		if(($entity = get_entity($guid)) && elgg_instanceof($entity, "object", "blog")){
			
			// load autocomplete
// 			elgg_load_js('elgg.autocomplete');

			$title_text = sprintf(elgg_echo("blog_tools:transfer:title"), $entity->title);
			$title = elgg_view_title($title_text);
			
			$body = elgg_view("blog_tools/forms/transfer", array("entity" => $entity));
			
		} else {
			$body = elgg_view("page/components/module", array("body" => elgg_echo("blog_tools:action:error:guid")));
		}
	} else {
		$body = elgg_view("page/components/module", array("body" => elgg_echo("blog_tools:action:error:input")));
	}

	$page_data = "<div id='blog_tools_transfer_wrapper'>";
	$page_data .= $title;
	$page_data .= $body;
	$page_data .= "</div>";
	
	echo elgg_view_page($title_text, $page_data, "lightbox");