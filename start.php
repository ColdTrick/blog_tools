<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/events.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");
	
	function blog_tools_init(){
		
		// overrule blog actions
		elgg_register_action('blog/save', dirname(__FILE__) . "/actions/blog/save.php");
		elgg_register_action('blog/auto_save_revision', dirname(__FILE__) . "/actions/blog/auto_save_revision.php");
		
		// Register an icon handler for blog
		elgg_register_page_handler("blogicon", "blog_tools_icon_handler");
		
		// extend blog page_handler
		elgg_register_plugin_hook_handler("route", "blog", "blog_tools_route_blog_hook");
		
		// extend livesearch page_handler
		elgg_register_plugin_hook_handler("route", "livesearch", "blog_tools_route_livesearch_hook");
		
		// Now override icons
		elgg_register_plugin_hook_handler("entity:icon:url", "object", "blog_tools_icon_hook");
		
		// get items in blog menu
		elgg_register_plugin_hook_handler("register", "menu:entity", "blog_tools_entity_menu_setup");
		
		// extend css
		elgg_extend_view("css/elgg", "css/blog_tools/site");
		
		// extend editmenu
		elgg_extend_view("editmenu", "blog_tools/editmenu");
		
		// add featured filter menu item
		elgg_register_menu_item("filter", ElggMenuItem::factory(array(
				"name" => "featured",
				"text" => elgg_echo("blog_tools:menu:filter:featured"),
				"context" => "blog",
				"href" => "blog/featured",
				"priority" => 600
			)));
		
		// register index widget
		elgg_register_widget_type("index_blog", elgg_echo("blog"), elgg_echo("blog_tools:widgets:index_blog:description"), "index", true);
	}
	
	// register default elgg events
	elgg_register_event_handler("init", "system", "blog_tools_init");

	// register event handlers
	elgg_register_event_handler("delete", "object", "blog_tools_delete_handler");
	
	// register plugin hook handlers
	elgg_register_plugin_hook_handler("widget_url", "widget_manager", "blog_tools_widget_url_handler");
	elgg_register_plugin_hook_handler("cron", "daily", "blog_tools_daily_cron_hook");
	
	// register actions
	elgg_register_action("blog_tools/toggle_metadata", dirname(__FILE__) . "/actions/toggle_metadata.php", "admin");