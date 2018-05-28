<?php

namespace ColdTrick\BlogTools;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function init() {
		
		// extend css
		elgg_extend_view('css/elgg', 'css/blog_tools/site.css');
		
		// extra blog views
		elgg_extend_view('object/elements/full/body', 'blog_tools/full/owner');
		elgg_extend_view('object/blog/elements/sidebar', 'blog_tools/sidebar/related');
		
		elgg_extend_view('forms/blog/save', 'blog_tools/edit/show_owner');
		elgg_extend_view('forms/blog/save', 'blog_tools/edit/force_notification');
		elgg_extend_view('forms/blog/save', 'blog_tools/edit/publication_options');
		
		// register plugin hook handlers
		$hooks = $this->elgg()->hooks;
		$hooks->registerHandler('entity:url', 'object', __NAMESPACE__ . '\Widgets::widgetUrl');
		$hooks->registerHandler('cron', 'daily', __NAMESPACE__ . '\Cron::daily');
		$hooks->registerHandler('get', 'subscriptions', __NAMESPACE__ . '\Notifications::forceAddSubscriptions');
		$hooks->registerHandler('register', 'menu:entity', __NAMESPACE__ . '\EntityMenu::register');
		$hooks->registerHandler('filter_tabs', 'blog', __NAMESPACE__ . '\FilterTabs::addFeatured');
		$hooks->registerHandler('group_tool_widgets', 'widget_manager', __NAMESPACE__ . '\Widgets::groupTools');
		$hooks->registerHandler('permissions_check:comment', 'object', __NAMESPACE__ . '\Access::blogCanComment');
		$hooks->registerHandler('view_vars', 'input/form', __NAMESPACE__ . '\Views::blogEditFormVars');
	}
}
