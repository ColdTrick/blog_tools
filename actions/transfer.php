<?php

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	$user_guid = (int) get_input("user_guid");
	
	$forward_url = REFERER;
	
	if(!empty($guid) && !empty($user_guid)){
		if(($entity = get_entity($guid)) && $entity->canEdit() && ($user = get_user($user_guid))){
			if(elgg_instanceof($entity, "object", "blog", "ElggBlog")){
				if($entity->getOwner() != $user->getGUID()){
					$old_owner = $entity->getOwner();
					
					if($entity->getOwner() == $entity->getContainer()){
						$entity->owner_guid = $user->getGUID();
						$entity->container_guid = $user->getGUID();
					} else {
						$entity->owner_guid = $user->getGUID();
					}
					
					if($entity->save()){
						if(!empty($entity->icontime)){
							$prefix = "blogs/" . $entity->getGUID();
							
							$old_fh = new ElggFile();
							$old_fh->owner_guid = $old_owner;
							$old_fh->setFilename($prefix . ".jpg");
							
							if($old_fh->exists()){
								$new_fh = new ElggFile();
								$new_fh->owner_guid = $user->getGUID();
								$new_fh->setFilename($prefix . ".jpg");
								
								$new_fh->open("write");
								$new_fh->write($old_fh->grabFile());
								$new_fh->close();
								
								$old_fh->delete();
								
								$sizes = array("tiny", "small", "medium", "large");
								foreach($sizes as $size){
									$new_fh->setFilename($prefix . $size . ".jpg");
									$old_fh->setFilename($prefix . $size . ".jpg");
									
									$new_fh->open("write");
									$new_fh->write($old_fh->grabFile());
									$new_fh->close();
									
									$old_fh->delete();
								}
								
								$entity->icontime = time();
							}
						}
						
						$forward_url = $entity->getURL();
						
						system_message(sprintf(elgg_echo("blog_tools:action:transfer:success"), $user->name));
					} else {
						register_error(elgg_echo("blog_tools:action:transfer:error:transfer"));
					}
				} else {
					register_error(elgg_echo("blog_tools:action:transfer:error:owner"));
				}
			} else {
				register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, "ElggBlog")));
			}
		} else {
			register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward($forward_url);