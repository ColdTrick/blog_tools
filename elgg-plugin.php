<?php

use ColdTrick\BlogTools\FieldsHandler;
use ColdTrick\BlogTools\Forms\PrepareFields;

return [
	'plugin' => [
		'version' => '15.0',
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
		'fields' => [
			'object:blog' => [
				FieldsHandler::class => ['priority' => 501],
			],
		],
		'form:prepare:fields' => [
			'blog/save' => [
				PrepareFields::class => [],
			],
		],
		'group_tool_widgets' => [
			'widget_manager' => [
				'\ColdTrick\BlogTools\Widgets::groupTools' => [],
			],
		],
		'register' => [
			'menu:blog_archive' => [
				'\ColdTrick\BlogTools\Menus\BlogArchive::addArchive' => [],
			],
			'menu:entity' => [
				'\ColdTrick\BlogTools\Menus\Entity::register' => [],
			],
			'menu:filter:blog/group' => [
				'\ColdTrick\BlogTools\Menus\Filter::groupTabs' => [],
			],
			'menu:filter:filter' => [
				'\ColdTrick\BlogTools\Menus\Filter::addFeatured' => [],
				'\ColdTrick\BlogTools\Menus\Filter::addArchive' => [],
			],
		],
		'view_vars' => [
			'blog/sidebar/archives' => [
				'\ColdTrick\BlogTools\Views::preventBlogArchiveSidebar' => [],
			],
			'object/elements/imprint/contents' => [
				'\ColdTrick\BlogTools\Views::addPublicationDateImprint' => [],
			],
		],
	],
	'view_extensions' => [
		'elgg.css' => [
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
