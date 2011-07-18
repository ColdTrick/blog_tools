<?php

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	$metadata = get_input("metadata");
	
	if(!empty($guid) && !empty($metadata)){
		if($entity = get_entity($guid)){
			if($entity->canEdit() && ($entity->getSubtype() == "blog")){
				$old = $entity->$metadata;
				
				if(empty($entity->$metadata)){
					$entity->$metadata = true;
				} else {
					unset($entity->$metadata);
				}
				
				if($old != $entity->$metadata){
					system_message(elgg_echo("blog_tools:action:toggle_metadata:success"));
				} else {
					register_error(elgg_echo("blog_tools:action:toggle_metadata:error"));
				}
			} else {
				register_error(elgg_echo("blog_tools:action:error:entity"));
			}
		} else {
			register_error(elgg_echo("blog_tools:action:error:guid"));
		}
	} else {
		register_error(elgg_echo("blog_tools:action:error:input"));
	}
	
	forward(REFERER);