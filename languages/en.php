<?php

return [
	'blog_tools' => "Blog tools",
	
	'blog_tools:toggle:feature' => "Feature",
	'blog_tools:toggle:unfeature' => "Unfeature",
	'blog_tools:readmore' => "read more",
	
	// notifications
	'blog_tools:notify:publish:subject' => "A blog has been published",
	'blog_tools:notify:publish:message' => "Hi,

your blog '%s' has been published.

You can view your blog here:
%s",
	
	// views
	'blog_tools:view:related' => "Related blogs",
	
	// blog edit
	'blog_tools:label:show_owner' => "Show information about yourself below the blog",
	
	'blog_tools:label:publication_options' => "Publication options",
	'blog_tools:label:publication_date' => "Publication date (optional)",
	'blog_tools:publication_date:description' => "When you select a date here the blog will not be published until the selected date.",
	'blog_tools:label:publication_time' => "Publication time ",
	'blog_tools:publication_time:description' => "In combination with the publication date this will set the time for publication.",
	'blog_tools:imprint:publication' => "Scheduled for publication: %s",
	
	'blog_tools:force_notification' => "Send a publish notification to all users when the blog is published",

	// settings
	'blog_tools:settings:image' => "Blog image settings",
	'blog_tools:settings:other' => "Other settings",
	'blog_tools:settings:menu' => "Menu settings",
	
	'blog_tools:settings:featured_menu' => "Add featured tab to blog listing pages",
	'blog_tools:settings:featured_menu:help' => "To show an easy list of all the featured blogs",
	'blog_tools:settings:archive_menu' => "Move blog archive sidebar to filter menu",
	'blog_tools:settings:archive_menu:help' => "On listing pages an archive is shown in the sidebar, with this setting the archive can be moved to the filter menu tabs.",
	
	'blog_tools:settings:listing:image_align' => "Blog listing image align",
	'blog_tools:settings:listing:image_size' => "Blog listing image size",
	
	'blog_tools:settings:full:image_align' => "Blog full view image align",
	'blog_tools:settings:full:image_size' => "Blog full view image size",
	
	'blog_tools:settings:full' => "Blog full view settings",
	'blog_tools:settings:full:show_full_owner' => "Show blog owner information below blog",
	'blog_tools:settings:full:show_full_owner:optional' => "Optional, blog owner decides",
	'blog_tools:settings:full:show_full_related' => "Show related blogs in the sidebar",
	
	'blog_tools:settings:align:none' => "No image",
	
	'blog_tools:settings:listing:strapline' => "How to show the imprint in listings",
	'blog_tools:settings:strapline:default' => "Default (owner, group, access, tags, etc.)",
	'blog_tools:settings:strapline:time' => "Time only",
	
	'blog_tools:settings:advanced_publication' => "Allow advanced publication options",
	'blog_tools:settings:advanced_publication:description' => "With this users can select a publication date for blogs. Requires a working CRON.",
	
	'blog_tools:settings:force_notification' => "Force notifications for new blogs",
	'blog_tools:settings:force_notification:help' => "Gives blog creators the ability to notify all users when a new blog is created. The notification preferences of the receiving users will still be respected. This only is available for personal blogs.",
	
	// actions
	'blog_tools:action:toggle_feature:success:feature' => "The blog was featured",
	'blog_tools:action:toggle_feature:success:unfeature' => "The blog is no longer featured",
	'blog_tools:action:toggle_feature:error:feature' => "An error occured while featuring the blog",
	'blog_tools:action:toggle_feature:error:unfeature' => "An error occured while unfeaturing the blog",
	
	// widget
	'blog_tools:widget:featured' => "Show only featured blogs?",
	
	'widgets:index_blog:name' => "Blog posts",
	'widgets:index_blog:description' => "Show the latest blogs on your community",
	
	'blog_tools:widgets:index_blog:view_mode' => "How to view the blogs",
	'blog_tools:widgets:index_blog:view_mode:list' => "List",
	'blog_tools:widgets:index_blog:view_mode:preview' => "Preview",
	'blog_tools:widgets:index_blog:view_mode:slider' => "Slider",
	'blog_tools:widgets:index_blog:view_mode:simple' => "Simple",
];
