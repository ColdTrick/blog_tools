<?php

return [
	'blog_tools' => "Blog tools",
	
	'blog_tools:readmore' => "read more",
	
	'collection:object:blog:tag' => "Blogs with the tag: %s",
	
	// notifications
	'blog_tools:notify:publish:subject' => "A blog has been published",
	'blog_tools:notify:publish:message' => "your blog '%s' has been published.

You can view your blog here:
%s",
	
	// views
	'blog_tools:view:related' => "Related blogs",
	
	// blog edit
	'blog_tools:label:publication_date' => "Publication date (optional)",
	'blog_tools:publication_date:description' => "When you select a date here the blog will not be published until the selected date.",
	'blog_tools:label:publication_time' => "Publication time ",
	'blog_tools:publication_time:description' => "In combination with the publication date this will set the time for publication.",
	
	'blog_tools:edit:access:help' => "Please select the access level of the blog for when the status is set to 'published'",
	'blog_tools:edit:access:help:publication' => "When using a publication date/time, the access level will be set to private until the publication date. Upon publication the selected access level will be used.",
	
	// view
	'blog_tools:imprint:publication' => "Scheduled for publication: %s",
	
	// settings
	'blog_tools:settings:other' => "Other settings",
	'blog_tools:settings:menu' => "Menu settings",
	
	'blog_tools:settings:featured_menu' => "Add featured tab to blog listing pages",
	'blog_tools:settings:featured_menu:help' => "To show an easy list of all the featured blogs",
	'blog_tools:settings:archive_menu' => "Move blog archive sidebar to filter menu",
	'blog_tools:settings:archive_menu:help' => "On listing pages an archive is shown in the sidebar, with this setting the archive can be moved to the filter menu tabs.",
	
	'blog_tools:settings:full:show_full_related' => "Show related blogs in the sidebar",
		
	'blog_tools:settings:advanced_publication' => "Allow advanced publication options",
	'blog_tools:settings:advanced_publication:description' => "With this users can select a publication date for blogs. Requires a working CRON.",
	
	// actions
	'blog_tools:action:toggle_feature:success:feature' => "The blog was featured",
	'blog_tools:action:toggle_feature:success:unfeature' => "The blog is no longer featured",
	
	// widget
	'blog_tools:widget:featured' => "Show only featured blogs?",
	
	'widgets:index_blog:name' => "Blog posts",
	'widgets:index_blog:description' => "Show the latest blogs on your community",
	
	'blog_tools:widgets:index_blog:view_mode' => "How to view the blogs",
	'blog_tools:widgets:index_blog:view_mode:list' => "List",
	'blog_tools:widgets:index_blog:view_mode:preview' => "Preview",
	'blog_tools:widgets:index_blog:view_mode:slider' => "Slider",
	'blog_tools:widgets:index_blog:view_mode:simple' => "Simple",
	
	'blog_tools:upgrade:2023032800:title' => "Move blog icons to header images",
	'blog_tools:upgrade:2023032800:description' => "In Elgg 5 there is built in header image support. This migration moves old icons uploaded with blogs to this new location.",
];
