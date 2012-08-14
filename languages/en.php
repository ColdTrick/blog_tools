<?php

	$english = array(
		'blog_tools' => "Blog tools",
		
		'blog_tools:toggle:feature' => "Feature",
		'blog_tools:toggle:unfeature' => "Unfeature",
		'blog_tools:transfer' => "Transfer owner",
		'blog_tools:readmore' => "read more",
		
		// widget
		'blog_tools:widget:featured' => "Show only featured blogs?",
		
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
		// blog edit
		'blog_tools:label:icon:exists' => "Upload icon (leave empty to keep current icon)",
		'blog_tools:label:icon:new' => "Upload icon",
		'blog_tools:label:icon:remove' => "Remove icon",
		
		'blog_tools:label:publication_options' => "Publication options",
		'blog_tools:label:publication_date' => "Publication date (optional)",
		'blog_tools:publication_date:description' => "When you select a date here the blog will not be published until the selected date.",
		'blog_tools:label:expiration_date' => "Expiration date (optional)",
		'blog_tools:expiration_date:description' => "The blog will no longer be published after the selected date.",
	
		// transfer owner
		'blog_tools:transfer:title' => "Transfer owner of: %s",
		'blog_tools:transfer:description' => "Here you can transfer the ownership of the blog. Type the name (or username) of the new owner and select him/her from the list. Then click on Transfer and the blog will be transfered.",
		'blog_tools:transfer:form:new_owner' => "Type the name of the new owner",
		'blog_tools:transfer:form:submit' => "Transfer",
		
		// settings
		'blog_tools:settings:image' => "Blog image settings",
		'blog_tools:settings:other' => "Other settings",
		
		'blog_tools:settings:listing:image_align' => "Blog listing image align",
		'blog_tools:settings:listing:image_size' => "Blog listing image size",
		
		'blog_tools:settings:full:image_align' => "Blog full view image align",
		'blog_tools:settings:full:image_size' => "Blog full view image size",
		
		'blog_tools:settings:align:none' => "No image",
		'blog_tools:settings:align:left' => "Left",
		'blog_tools:settings:align:right' => "Right",
		
		'blog_tools:settings:size:tiny' => "Tiny (16x16)",
		'blog_tools:settings:size:small' => "Small (40x40)",
		'blog_tools:settings:size:medium' => "Medium (100x100)",
		'blog_tools:settings:size:large' => "Large (200x200)",
		
		'blog_tools:settings:listing:strapline' => "Show strapline in listing",
		'blog_tools:settings:strapline:default' => "Default (owner and tags)",
		'blog_tools:settings:strapline:time' => "Time only",
		
		'blog_tools:settings:advanced_gatekeeper' => "Use advanced blog gatekeeper",
		'blog_tools:settings:advanced_gatekeeper:description' => "This will help non loggedin users to find their way to a protected blog more easily",
		
		'blog_tools:settings:advanced_publication' => "Allow advanced publication options",
		'blog_tools:settings:advanced_publication:description' => "With this users can select a publication and expiration date for blogs. Requires a working daily CRON.",
		
		// actions
		'blog_tools:action:toggle_metadata:error' => "An unknown error occured while editing the entity, please try agian",
		'blog_tools:action:toggle_metadata:success' => "The entity was successfully edited",
		
		'blog_tools:action:transfer:error:owner' => "You can't transfer the blog to the same user",
		'blog_tools:action:transfer:error:transfer' => "An unknown error occured while transfering the blog, please try again",
		'blog_tools:action:transfer:success' => "Blog successfully transfered",
		
		'blog_tools:action:save:error:expiration_date' => "The expiration date can't be before today",
		
		// widget
		'blog_tools:widgets:index_blog:description' => "Show the latest blogs on your community",
		
		'blog_tools:widgets:index_blog:view_mode' => "How to view the blogs",
		'blog_tools:widgets:index_blog:view_mode:list' => "List",
		'blog_tools:widgets:index_blog:view_mode:preview' => "Preview",
		'blog_tools:widgets:index_blog:view_mode:slider' => "Slider",
		'blog_tools:widgets:index_blog:view_mode:simple' => "Simple",
	);
	
	add_translation("en", $english);