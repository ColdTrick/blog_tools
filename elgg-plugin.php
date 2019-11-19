<?php

use ColdTrick\BlogTools\Bootstrap;

require_once(__DIR__ . '/lib/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	'actions' => [
		'blog/save' => [],
		'blog_tools/toggle_featured' => [
			'access' => 'admin',
		],
	],
	'routes' => [
		'collection:object:blog:featured' => [
			'path' => '/blog/featured',
			'resource' => 'blog/featured',
		],
		'collection:object:blog:tag' => [
			'path' => '/blog/tag/{tag}/{lower?}/{upper?}',
			'resource' => 'blog/tag',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
		],
	],
	'settings' => [
		'listing_align' => 'right',
		'listing_size' => 'small',
		'full_align' => 'right',
		'full_size' => 'large',
		'featured_menu' => 1,
		'archive_menu' => 0,
		'advanced_publication' => 'no',
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
