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
					
					// transfer owner link
					// @todo: mak this work again
					// need fancybox
					/* 
					elgg_load_js("lightbox");
					elgg_load_css("lightbox");
					elgg_load_js("elgg.autocomplete");
					// init fancybox
					elgg_extend_view("page/elements/head", "blog_tools/metatags");
					
					$options = array(
						"name" => "transfer_owner",
						"text" => elgg_echo("blog_tools:transfer"),
						"href" => elgg_get_site_url() . "blog/transfer/" . $entity->getGUID(),
						"class" => "iframe",
						"priority" => 175
					);
					
					$result[] = ElggMenuItem::factory($options);
					 */
				}
			}
		}
		
		return $result;
	}
	
	function blog_tools_route_blog_hook($hook, $type, $returm_value, $params){
		$result = $returm_value;
		
		if($page = elgg_extract("segments", $returm_value)){
			
			switch ($page[0]){
				case "read": // Elgg 1.7 compatibility
				case "view":
					if(!elgg_is_logged_in() && (elgg_get_plugin_setting("advanced_gatekeeper", "blog_tools") != "no")){
						if(isset($page[1]) && !get_entity($page[1])){
							gatekeeper();
						}
					}
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
				case "transfer":
					$result = false;
					
					if(isset($page[1])){
						set_input("guid", $page[1]);
					}
				
					include(dirname(dirname(__FILE__)) . "/pages/transfer.php");
					break;
			}
		}
		
		return $result;
	}
	
	function blog_tools_route_livesearch_hook($hook, $type, $returm_value, $params){
		$result = $returm_value;
		
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