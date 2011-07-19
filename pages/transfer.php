<?php

	/**
	 * fancybox view, so no page draw
	 */

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	
	if(!empty($guid)){
		if(($entity = get_entity($guid)) && ($entity->getSubtype() == "blog")){
			$title_text = sprintf(elgg_echo("blog_tools:transfer:title"), $entity->title);
			$title = elgg_view_title($title_text);
			
			$body = elgg_view("blog_tools/forms/transfer", array("entity" => $entity));
			
			
		} else {
			$body = elgg_view("page_elements/contentwrapper", array("body" => elgg_echo("blog_tools:action:error:guid")));
		}
	} else {
		$body = elgg_view("page_elements/contentwrapper", array("body" => elgg_echo("blog_tools:action:error:input")));
	}
	
	echo "<div id='blog_tools_transfer_wrapper'>";
	echo $title;
	echo $body;
	echo "</div>";