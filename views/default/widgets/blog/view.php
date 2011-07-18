<?php

	$widget = $vars["entity"];

	//get the num of blog entries the user wants to display
	$num = (int) $widget->num_display;

	//if no number has been set, default to 4
	if ($num < 1) {
		$num = 4;
	}

	$context = get_context();
	set_context('search');
	
	$options = array(
		'type' => 'object', 
		'subtype' => 'blog', 
		'container_guid' => $widget->getOwner(), 
		'limit' => $num, 
		'full_view' => false, 
		'pagination' => false
	);
	
	if($widget->show_featured == "yes"){
		$options["metadata_name_value_pairs"] = array("featured" => true);
	}
	
	if($content = elgg_list_entities_from_metadata($options)){
		echo $content;
		
		if($widget->context != "index"){
			$blogurl = $vars["url"] . "pg/blog/owner/" . $widget->getOwnerEntity()->username;
		} else {
			$blogurl = $vars["url"] . "pg/blog/all/";
		}
		echo "<div class='widget_more_wrapper'>";
		echo elgg_view("output/url", array("href" => $blogurl, "text" => elgg_echo("blog:moreblogs")));
		echo "</div>";
	} else {
		echo elgg_view("page_elements/contentwrapper", array("body" => elgg_echo("blog_tools:no_blogs")));
	}
	
	set_context($context);
	
	