<?php

use ColdTrick\BlogTools\Upgrades\MoveHeaderIcons;

return [
	'plugin' => [
		'version' => '11.0',
		'dependencies' => [
			'blog' => [
				'position' => 'after',
			],
		],
	],
	'settings' => [
		'featured_menu' => true,
		'archive_menu' => false,
		'advanced_publication' => 'no',
	],
	'upgrades' => [
		MoveHeaderIcons::class,
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
	'events' => [
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
			'widgets/index_blog/content.css' => [],
		],
		'forms/blog/save' => [
			'blog_tools/edit/publication_options' => [],
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
