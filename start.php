<?php
	function blog_tools_init(){
		register_action("blog/add", false, dirname(__FILE__) . "/actions/blog/add.php");
		register_action("blog/edit", false, dirname(__FILE__) . "/actions/blog/edit.php");
		
		// Register an icon handler for blog
		register_page_handler("blogicon", "blog_tools_icon_handler");
		
		// Now override icons
		register_plugin_hook("entity:icon:url", "object", "blog_tools_icon_hook");
		
		// extend editmenu
		elgg_extend_view("editmenu", "blog_tools/editmenu");
	}
	
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
	
	function blog_tools_icon_handler($page) {
		global $CONFIG;

		// The username should be the file we"re getting
		if (isset($page[0])) {
			set_input("guid",$page[0]);
		}
		if (isset($page[1])) {
			set_input("size",$page[1]);
		}
		
		// Include the standard profile index
		include(dirname(__FILE__) . "/pages/icon.php");
	}

	// register default elgg events
	register_elgg_event_handler("init", "system", "blog_tools_init");	

	// register actions
	register_action("blog_tools/toggle_metadata", false, dirname(__FILE__) . "/actions/toggle_metadata.php", true);
	register_action("blog_tools/transfer", false, dirname(__FILE__) . "/actions/transfer.php", true);