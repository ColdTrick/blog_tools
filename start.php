<?php
/**
 * The main file for this plugin
 */

require_once(__DIR__ . '/lib/functions.php');

// register default elgg events
elgg_register_event_handler('init', 'system', 'blog_tools_init');

/**
 * This function gets called during the system initialization
 *
 * @return void
 */
function blog_tools_init() {
	
	// extend css
	elgg_extend_view('css/elgg', 'css/blog_tools/site.css');
	
	// extra blog views
	elgg_extend_view('object/elements/full/body', 'blog_tools/full/owner');
	elgg_extend_view('object/blog/elements/sidebar', 'blog_tools/sidebar/related');
	
	elgg_extend_view('forms/blog/save', 'blog_tools/edit/show_owner');
	elgg_extend_view('forms/blog/save', 'blog_tools/edit/force_notification');
	elgg_extend_view('forms/blog/save', 'blog_tools/edit/publication_options');
	
	// register plugin hook handlers
	elgg_register_plugin_hook_handler('entity:url', 'object', '\ColdTrick\BlogTools\Widgets::widgetUrl');
	elgg_register_plugin_hook_handler('cron', 'daily', '\ColdTrick\BlogTools\Cron::daily');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\BlogTools\Notifications::forceAddSubscriptions');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\BlogTools\EntityMenu::register');
	elgg_register_plugin_hook_handler('filter_tabs', 'blog', '\ColdTrick\BlogTools\FilterTabs::addFeatured');
	elgg_register_plugin_hook_handler('group_tool_widgets', 'widget_manager', '\ColdTrick\BlogTools\Widgets::groupTools');
	elgg_register_plugin_hook_handler('permissions_check:comment', 'object', '\ColdTrick\BlogTools\Access::blogCanComment');
	elgg_register_plugin_hook_handler('view_vars', 'input/form', '\ColdTrick\BlogTools\Views::blogEditFormVars');
}
