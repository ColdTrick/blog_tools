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
					// need fancybox
					elgg_load_js('lightbox');
					elgg_load_css('lightbox');
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
				}
			}
		}
		
		return $result;
	}