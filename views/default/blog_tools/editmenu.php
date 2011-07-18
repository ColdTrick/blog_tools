<?php

	if(isset($vars["entity"])){
		$entity = $vars["entity"];
		
		if(!empty($entity) && ($entity instanceof ElggObject) && ($entity->getSubtype() == "blog")){
			if(isadminloggedin()){
				if(!empty($entity->featured)){
					$text = elgg_echo("blog_tools:toggle:unfeature");
				} else {
					$text = elgg_echo("blog_tools:toggle:feature");
				}
				
				echo "&nbsp;&nbsp;&nbsp;&nbsp;" . elgg_view("output/url", array("href" => $vars["url"] . "action/blog_tools/toggle_metadata?guid=" . $entity->getGUID() . "&metadata=featured", "text" => $text, "is_action" => true));
			}
		}
	}