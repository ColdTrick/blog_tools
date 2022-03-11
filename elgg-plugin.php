<?php

require_once(__DIR__ . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '9.0.3',
		'dependencies' => [
			'blog' => [
				'position' => 'after',
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
	'hooks' => [
		'cron' => [
			'fifteenmin' => [
				'\ColdTrick\BlogTools\Cron::publication' => [],
			],
		],
		'entity:url' => [
			'object' => [
				'\ColdTrick\BlogTools\Widgets::widgetUrl' => [],
			],
		],
		'group_tool_widgets' => [
			'widget_manager' => [
				'\ColdTrick\BlogTools\Widgets::groupTools' => [],
			],
		],
		'register' => [
			'menu:blog_archive' => [
				'\ColdTrick\BlogTools\BlogArchiveMenu::addArchive' => [],
			],
			'menu:entity' => [
				'\ColdTrick\BlogTools\EntityMenu::register' => [],
			],
			'menu:filter:blog/group' => [
				'\ColdTrick\BlogTools\FilterTabs::groupTabs' => [],
			],
			'menu:filter:filter' => [
				'\ColdTrick\BlogTools\FilterTabs::addFeatured' => [],
				'\ColdTrick\BlogTools\FilterTabs::addArchive' => [],
			],
		],
		'view_vars' => [
			'blog/sidebar/archives' => [
				'\ColdTrick\BlogTools\Views::preventBlogArchiveSidebar' => [],
			],
		],
	],
	'view_extensions' => [
		'css/elgg' => [
			'css/blog_tools/site.css' => [],
		],
		'forms/blog/save' => [
			'blog_tools/edit/show_owner' => [],
			'blog_tools/edit/publication_options' => [],
		],
		'object/elements/full/body' => [
			'blog_tools/full/owner' => [],
		],
		'object/blog/elements/sidebar' => [
			'blog_tools/sidebar/related' => [],
		],
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
