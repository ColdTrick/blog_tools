<?php

	function blog_tools_icon_hook($hook, $entity_type, $returnvalue, $params) {
		
		if (!empty($params) && is_array($params)) {
			$entity = $params["entity"];
			
			if(elgg_instanceof($entity, "object", "blog")){
				$size = $params["size"];
		
				if ($icontime = $entity->icontime) {
					$icontime = "{$icontime}";
						
					$filehandler = new ElggFile();
					$filehandler->owner_guid = $entity->getOwnerGUID();
					$filehandler->setFilename("blogs/" . $entity->getGUID() . $size . ".jpg");
		
					if ($filehandler->exists()) {
						$url = elgg_get_site_url() . "blogicon/{$entity->getGUID()}/$size/$icontime.jpg";
							
						return $url;
					}
				}
			}
		}
	}
	
	function blog_tools_entity_menu_setup($hook, $entity_type, $returnvalue, $params){
		$result = $returnvalue;
		
		if (elgg_in_context("widgets")) {
			return $result;
		}
		
		if(!empty($params) && is_array($params)){
			if(($entity = elgg_extract("entity", $params)) && elgg_instanceof($entity, "object", "blog")){
				if(elgg_is_admin_logged_in()){
					
					// feature link
					if(!empty($entity->featured)){
						$text = elgg_echo("blog_tools:toggle:unfeature");
					} else {
						$text = elgg_echo("blog_tools:toggle:feature");
					}
					
					$options = array(
						"name" => "featured",
						"text" => $text,
						"href" => elgg_get_site_url() . "action/blog_tools/toggle_metadata?guid=" . $entity->getGUID() . "&metadata=featured",
						"is_action" => true,
						"priority" => 175
					);
					
					$result[] = ElggMenuItem::factory($options);
				}
			}
		}
		
		return $result;
	}
	
	function blog_tools_route_blog_hook($hook, $type, $return_value, $params){
		$result = $return_value;
		
		if($page = elgg_extract("segments", $return_value)){
			
			switch ($page[0]){
				case 'owner':
					if($user = get_user_by_username($page[1])){
						$result = false;
						// push all blogs breadcrumb
						elgg_push_breadcrumb(elgg_echo('blog:blogs'), "blog/all");
						
						set_input("owner_guid", $user->guid);
						include(dirname(dirname(__FILE__)) . "/pages/owner.php");
						break;
					}
				case "read": // Elgg 1.7 compatibility
				case "view":
					$result = false;
					
					if(!elgg_is_logged_in() && (elgg_get_plugin_setting("advanced_gatekeeper", "blog_tools") != "no")){
						if(isset($page[1]) && !get_entity($page[1])){
							gatekeeper();
						}
					}
					
					set_input("guid", $page[1]);
					
					include(dirname(dirname(__FILE__)) . "/pages/view.php");
					break;
				case "add":
				case "edit":
					$result = false;
					// push all blogs breadcrumb
					elgg_push_breadcrumb(elgg_echo("blog:blogs"), "blog/all");
					
					set_input("page_type", $page[0]);
					if(isset($page[1])){
						set_input("guid", $page[1]);
					}
					if(isset($page[2])){
						set_input("revision", $page[2]);
					}
					
					include(dirname(dirname(__FILE__)) . "/pages/edit.php");
					break;
				case "featured":
					$result = false;
									
					include(dirname(dirname(__FILE__)) . "/pages/featured.php");
					break;
			}
		}
		
		return $result;
	}
	
	function blog_tools_route_livesearch_hook($hook, $type, $return_value, $params){
		$result = $return_value;
		
		if(!elgg_is_logged_in()){
			exit();
		}
		
		if(!($q = get_input("term"))){
			exit();
		}
		
		$match_on = get_input("match_on");
		$limit = (int) get_input("limit", 10);
		if($limit < 1){
			$limit = 10;
		}
		
		if(!empty($match_on) && ($match_on == "users_of_site")){
			$result = false;
			
			$q = sanitise_string($q);
			
			$return = array();
			
			$options = array(
				"type" => "user",
				"relationship" => "member_of_site",
				"relationship_guid" => get_config("site_guid"),
				"inverse_relationship" => true,
				"limit" => $limit,
				"joins" => array("JOIN " . get_config("dbprefix") . "users_entity ue ON e.guid = ue.guid"),
				"wheres" => array("(ue.username LIKE '%" . $q . "%' OR ue.name LIKE '%" . $q . "%')")
			);
			
			if($users = elgg_get_entities_from_relationship($options)){
				foreach($users as $user){
					$json = json_encode(array(
						'type' => 'user',
						'name' => $user->name,
						'desc' => $user->username,
						'icon' => '<img class="livesearch_icon" src="' . $user->getIcon('tiny') . '" />',
						'guid' => $user->getGUID()
					));
					
					$return[$user->name . rand(1,100)] = $json;
				}
			}
			
			ksort($return);
			echo implode($return, "\n");
			
			exit();
		}
		
		return $result;
	}
	
	function blog_tools_widget_url_handler($hook, $type, $return_value, $params){
		$result = $return_value;
		
		if(!$result && !empty($params) && is_array($params)){
			$widget = elgg_extract("entity", $params);
				
			if(!empty($widget) && elgg_instanceof($widget, "object", "widget")){
				switch($widget->handler){
					case "index_blog":
						$result = "blog/all";
						break;
					case "blog":
						$owner = $widget->getOwnerEntity();
						if(elgg_instanceof($owner, "user")){
							$result = "blog/owner/" . $owner->username;
						} elseif(elgg_instanceof($owner, "group")){
							$result = "blog/group/" . $owner->getGUID() . "/all";
						}
						break;
				}
			}
		}
		
		return $result;
	}
	
	function blog_tools_daily_cron_hook($hook, $type, $return_value, $params){
		
		// only do if this is configured
		if(blog_tools_use_advanced_publication_options()){
			$dbprefix = elgg_get_config("dbprefix");
			$publication_id = add_metastring("publication_date");
			$expiration_id = add_metastring("expiration_date");
			
			$time = elgg_extract("time", $params, time());
			
			$publish_options = array(
				"type" => "object",
				"subtype" => "blog",
				"limit" => false,
				"joins" => array(
					"JOIN " . $dbprefix . "metadata mdtime ON e.guid = mdtime.entity_guid",
					"JOIN " . $dbprefix . "metastrings mstime ON mdtime.value_id = mstime.id"
				),
				"metadata_name_value_pairs" => array(
					array(
						"name" => "status",
						"value" => "draft"
					)
				),
				"wheres" => array("((mdtime.name_id = " . $publication_id . ") AND (DATE(mstime.string) = DATE(NOW())))")
			);
			
			$unpublish_options = array(
				"type" => "object",
				"subtype" => "blog",
				"limit" => false,
				"joins" => array(
					"JOIN " . $dbprefix . "metadata mdtime ON e.guid = mdtime.entity_guid",
					"JOIN " . $dbprefix . "metastrings mstime ON mdtime.value_id = mstime.id"
				),
				"metadata_name_values_pairs" => array(
					array(
						"name" => "status",
						"value" => "published"
					)
				),
				"wheres" => array("((mdtime.name_id = " . $expiration_id . ") AND (DATE(mstime.string) = DATE(NOW())))")
			);
			
			// ignore access
			$ia = elgg_set_ignore_access(true);
			
			// get unpublished blogs that need to be published
			if($entities = elgg_get_entities_from_metadata($publish_options)){
				foreach ($entities as $entity){
					// add river item
					add_to_river("river/object/blog/create", "create", $entity->getOwnerGUID(), $entity->getGUID());
					
					// set correct time created
					$entity->time_created = $time;
					
					// publish blog
					$entity->status = "published";
					
					// notify owner
					notify_user($entity->getOwnerGUID(),
								$entity->site_guid,
								elgg_echo("blog_tools:notify:publish:subject"),
								elgg_echo("blog_tools:notify:publish:message", array(
									$entity->title,
									$entity->getURL()
								))
					);
					
					// save everything
					$entity->save();
				}
			}
			
			// get published blogs that need to be unpublished
			if($entities = elgg_get_entities_from_metadata($unpublish_options)){
				foreach ($entities as $entity){
					// remove river item
					elgg_delete_river(array(
						"object_guid" => $entity->getGUID(),
						"action_type" => "create",
					));
					
					// unpublish blog
					$entity->status = "draft";
					
					// notify owner
					notify_user($entity->getOwnerGUID(),
								$entity->site_guid,
								elgg_echo("blog_tools:notify:expire:subject"),
								elgg_echo("blog_tools:notify:expire:message", array(
									$entity->title,
									$entity->getURL()
								))
					);
					
					// save everything
					$entity->save();
				}
			}
			
			// reset access
			elgg_set_ignore_access($ia);
		}
	}
	