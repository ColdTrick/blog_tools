<?php

	function blog_tools_icon_hook($hook, $entity_type, $returnvalue, $params) {
		global $CONFIG;
	
		if ((!$returnvalue) && ($hook == "entity:icon:url") && ($params["entity"]->getSubtype() == "blog")) {
			$entity = $params["entity"];
			$size = $params["size"];
	
			if ($icontime = $entity->icontime) {
				$icontime = "{$icontime}";
					
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getOwner();
				$filehandler->setFilename("blogs/" . $entity->getGUID() . $size . ".jpg");
	
				if ($filehandler->exists()) {
					$url = $CONFIG->wwwroot . "pg/blogicon/{$entity->getGUID()}/$size/$icontime.jpg";
						
					return $url;
				}
			}
		}
	}