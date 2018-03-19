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
	
	'blog_tools:notify:expire:subject' => "A blog has expired",
	'blog_tools:notify:expire:message' => "Hi,

your blog '%s' has expired and is no longer visible for the community.

You can view your blog here:
%s",
	
	// views
	'blog_tools:view:related' => "Related blogs",
	
	// blog edit
	'blog_tools:label:icon:exists' => "Upload icon (leave empty to keep current icon)",
	'blog_tools:label:icon:new' => "Upload icon",
	'blog_tools:label:icon:remove' => "Remove icon",
	
	'blog_tools:label:show_owner' => "Show information about yourself below the blog",
	
	'blog_tools:label:publication_options' => "Publication options",
	'blog_tools:label:publication_date' => "Publication date (optional)",
	'blog_tools:publication_date:description' => "When you select a date here the blog will not be published until the selected date.",
	'blog_tools:label:expiration_date' => "Expiration date (optional)",
	'blog_tools:expiration_date:description' => "The blog will no longer be published after the selected date.",

	'blog_tools:force_notification' => "Send a publish notification to all users when the blog is published",

	// settings
	'blog_tools:settings:image' => "Blog image settings",
	'blog_tools:settings:other' => "Other settings",
	
	'blog_tools:settings:listing:image_align' => "Blog listing image align",
	'blog_tools:settings:listing:image_size' => "Blog listing image size",
	
	'blog_tools:settings:full:image_align' => "Blog full view image align",
	'blog_tools:settings:full:image_size' => "Blog full view image size",
	
	'blog_tools:settings:full' => "Blog full view settings",
	'blog_tools:settings:full:show_full_navigation' => "Show previous/next navigation",
	'blog_tools:settings:full:show_full_owner' => "Show blog owner information below blog",
	'blog_tools:settings:full:show_full_owner:optional' => "Optional, blog owner decides",
	'blog_tools:settings:full:show_full_related' => "Show related blogs",
	'blog_tools:settings:full:show_full_related:full_view' => "Below the blog",
	'blog_tools:settings:full:show_full_related:sidebar' => "In the sidebar",
	
	'blog_tools:settings:align:none' => "No image",
	
	'blog_tools:settings:size:tiny' => "Tiny (16x16)",
	'blog_tools:settings:size:small' => "Small (40x40)",
	'blog_tools:settings:size:medium' => "Medium (100x100)",
	'blog_tools:settings:size:large' => "Large (200x200)",
	'blog_tools:settings:size:master' => "Master (550x550)",
	
	'blog_tools:settings:listing:strapline' => "Show strapline in listing",
	'blog_tools:settings:strapline:default' => "Default (owner and tags)",
	'blog_tools:settings:strapline:time' => "Time only",
	
	'blog_tools:settings:advanced_publication' => "Allow advanced publication options",
	'blog_tools:settings:advanced_publication:description' => "With this users can select a publication and expiration date for blogs. Requires a working daily CRON.",
	
	'blog_tools:settings:force_notification' => "Force notifications for new blogs",
	'blog_tools:settings:force_notification:help' => "Gives blog creators the ability to notify all users when a new blog is created. The notification preferences of the receiving users will still be respected. This only is available for personal blogs.",
	
	// actions
	'blog_tools:action:save:error:expiration_date' => "The expiration date can't be before today",
	
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
