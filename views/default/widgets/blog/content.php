<?php

	$widget = $vars["entity"];

	//get the num of blog entries the user wants to display
	$num = (int) $widget->num_display;

	//if no number has been set, default to 4
	if ($num < 1) {
		$num = 4;
	}

	$options = array(
		'type' => 'object', 
		'subtype' => 'blog', 
		'container_guid' => $widget->getOwnerGUID(), 
		'limit' => $num, 
		'full_view' => false, 
		'pagination' => false
	);
	
	if($widget->show_featured == "yes"){
		$options["metadata_name_value_pairs"] = array("featured" => true);
	}
	
	if($content = elgg_list_entities_from_metadata($options)){
		echo $content;
		
		echo "<div class='elgg-widget-more'>";
		echo elgg_view("output/url", array("href" => $vars["url"] . "pg/blog/owner/" . $widget->getOwnerEntity()->username, "text" => elgg_echo("blog:moreblogs")));
		echo "</div>";
	} else {
		echo elgg_echo("blog:noblogs");
	}
	