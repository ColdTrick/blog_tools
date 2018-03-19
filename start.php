<?php
/**
 * The main file for this plugin
 */

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
	elgg_extend_view('object/blog', 'blog_tools/full/navigation');
	elgg_extend_view('object/blog', 'blog_tools/full/owner');
	elgg_extend_view('object/blog', 'blog_tools/full/related');
	elgg_extend_view('blog/sidebar', 'blog_tools/full/related');
	
	// register plugin hook handlers
	elgg_register_plugin_hook_handler('entity:url', 'object', '\ColdTrick\BlogTools\Widgets::widgetUrl');
	elgg_register_plugin_hook_handler('cron', 'daily', '\ColdTrick\BlogTools\Cron::daily');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\BlogTools\Notifications::forceAddSubscriptions');
	elgg_register_plugin_hook_handler('route', 'blog', '\ColdTrick\BlogTools\Router::blog');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\BlogTools\EntityMenu::register');
	elgg_register_plugin_hook_handler('group_tool_widgets', 'widget_manager', '\ColdTrick\BlogTools\Widgets::groupTools');
	elgg_register_plugin_hook_handler('permissions_check:comment', 'object', '\ColdTrick\BlogTools\Access::blogCanComment');
	elgg_register_plugin_hook_handler('view_vars', 'input/form', '\ColdTrick\BlogTools\Views::blogEditFormVars');
	
	// extend editmenu
	elgg_extend_view('editmenu', 'blog_tools/editmenu');
	
	// add featured filter menu item
	elgg_register_menu_item('filter', ElggMenuItem::factory([
		'name' => 'featured',
		'text' => elgg_echo('status:featured'),
		'context' => 'blog',
		'href' => 'blog/featured',
		'priority' => 600
	]));
	
	// overrule blog actions
	elgg_register_action('blog/save', dirname(__FILE__) . '/actions/blog/save.php');
	elgg_register_action('blog/auto_save_revision', dirname(__FILE__) . '/actions/blog/auto_save_revision.php');
}
