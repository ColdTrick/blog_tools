<?php

elgg_load_library('elgg:blog');

// extra views
elgg_extend_view("object/blog", "blog_tools/full/navigation");
elgg_extend_view("object/blog", "blog_tools/full/owner");
elgg_extend_view("object/blog", "blog_tools/full/related");

// push all blogs breadcrumb
elgg_push_breadcrumb(elgg_echo('blog:blogs'), "blog/all");

$params = blog_get_page_content_read($page[1]);

if (isset($params['sidebar'])) {
	$params['sidebar'] .= elgg_view('blog/sidebar', array('page' => "view"));
} else {
	$params['sidebar'] = elgg_view('blog/sidebar', array('page' => "view"));
}

$params['sidebar'] .= elgg_view("blog_tools/full/related", array("sidebar" => true));

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);
