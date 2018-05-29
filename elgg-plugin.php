<?php

use ColdTrick\BlogTools\Bootstrap;

require_once(__DIR__ . '/lib/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	'actions' => [
		'blog/save' => [],
		'blog_tools/toggle_metadata' => [
			'access' => 'admin',
		],
	],
	'routes' => [
		'collection:object:blog:featured' => [
			'path' => '/blog/featured',
			'resource' => 'blog/featured',
		],
	],
	'settings' => [
		'listing_align' => 'right',
		'listing_size' => 'small',
		'full_align' => 'right',
		'full_size' => 'large',
		'featured_menu' => 1,
		'archive_menu' => 0,
	],
	'widgets' => [
		'blog' => [
			'context' => ['profile', 'dashboard', 'groups'],
		],
		'index_blog' => [
			'context' => ['index'],
			'multiple' => true,
		],
	],
];
