<?php

return [
	'actions' => [
		'blog_tools/toggle_metadata' => [
			'access' => 'admin',
		],
	],
	'settings' => [
		'listing_align' => 'right',
		'listing_size' => 'small',
		'full_align' => 'right',
		'full_size' => 'large',
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
