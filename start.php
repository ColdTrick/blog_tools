<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/events.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");
	
	function blog_tools_init(){
		
		if(elgg_is_active_plugin("blog")){
			// overrule blog actions
			elgg_register_action('blog/save', dirname(__FILE__) . "/actions/blog/save.php");
			
			// Register an icon handler for blog
			elgg_register_page_handler("blogicon", "blog_tools_icon_handler");
			blog_tools_extend_page_handler("blog", "blog_tools_blog_page_handler");
			blog_tools_extend_page_handler("livesearch", "blog_tools_livesearch_page_handler");
			
			// Now override icons
			elgg_register_plugin_hook_handler("entity:icon:url", "object", "blog_tools_icon_hook");
			
			// get items in blog menu
			elgg_register_plugin_hook_handler("register", "menu:entity", "blog_tools_entity_menu_setup");
			
			// extend css
			elgg_extend_view("css/elgg", "blog_tools/css");
			
			// extend editmenu
			elgg_extend_view("editmenu", "blog_tools/editmenu");
			
			// register index widget
			elgg_register_widget_type("index_blog", elgg_echo("blog_tools:widgets:index_blog:name"), elgg_echo("blog_tools:widgets:index_blog:description"), "index", true);
			if(is_callable("add_widget_title_link")){
				add_widget_title_link("index_blog", "[BASEURL]blog/all/");
			}
		}
	}
	
	// register default elgg events
	elgg_register_event_handler("init", "system", "blog_tools_init");	

	elgg_register_event_handler("delete", "object", "blog_tools_delete_handler");
	
	// register actions
	elgg_register_action("blog_tools/toggle_metadata", dirname(__FILE__) . "/actions/toggle_metadata.php", "admin");
	elgg_register_action("blog_tools/transfer", dirname(__FILE__) . "/actions/transfer.php", "admin");