<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");

	function blog_tools_init(){
		
		if(is_plugin_enabled("blog")){
			// overrule blog actions
			register_action("blog/add", false, dirname(__FILE__) . "/actions/blog/add.php");
			register_action("blog/edit", false, dirname(__FILE__) . "/actions/blog/edit.php");
			
			// Register an icon handler for blog
			register_page_handler("blogicon", "blog_tools_icon_handler");
			blog_tools_extend_page_handler("blog", "blog_tools_blog_page_handler");
			blog_tools_extend_page_handler("livesearch", "blog_tools_livesearch_page_handler");
			
			// Now override icons
			register_plugin_hook("entity:icon:url", "object", "blog_tools_icon_hook");
			
			// extend css
			elgg_extend_view("css", "fancybox/css");
			elgg_extend_view("css", "blog_tools/css");
			elgg_extend_view("metatags", "blog_tools/metatags");
			
			// extend editmenu
			elgg_extend_view("editmenu", "blog_tools/editmenu");
			
			// register index widget
			add_widget_type("index_blog", elgg_echo("blog_tools:widgets:index_blog:name"), elgg_echo("blog_tools:widgets:index_blog:description"), "index", true);
			if(is_callable("add_widget_title_link")){
				add_widget_title_link("index_blog", "[BASEURL]pg/blog/all/");
			}
		}
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
	
	// register default elgg events
	register_elgg_event_handler("init", "system", "blog_tools_init");	

	// register actions
	register_action("blog_tools/toggle_metadata", false, dirname(__FILE__) . "/actions/toggle_metadata.php", true);
	register_action("blog_tools/transfer", false, dirname(__FILE__) . "/actions/transfer.php", true);