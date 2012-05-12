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
		$owner = $widget->getOwnerEntity();
		if(elgg_instanceof($owner, "group", null, "ElggGroup")){
			echo elgg_view("output/url", array("href" => $vars["url"] . "blog/group/" . $owner->getGUID() . "/all", "text" => elgg_echo("blog:moreblogs")));
		} else {
			echo elgg_view("output/url", array("href" => $vars["url"] . "blog/owner/" . $owner->username, "text" => elgg_echo("blog:moreblogs")));
		}
		echo "</div>";
	} else {
		echo elgg_echo("blog:noblogs");
	}
	