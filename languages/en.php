<?php

	$english = array(
		'blog_tools' => "Blog tools",
		
		'blog_tools:toggle:feature' => "Feature",
		'blog_tools:toggle:unfeature' => "Unfeature",
		'blog_tools:no_blogs' => "No blogs found",
		'blog_tools:transfer' => "Transfer owner",
		
		// widget
		'blog_tools:widget:featured' => "Show only featured blogs?",
		
		// views
		// transfer owner
		'blog_tools:transfer:title' => "Transfer owner of: %s",
		'blog_tools:transfer:description' => "Here you can transfer the ownership of the blog. Type the name (or username) of the new owner and select him/her from the list. Then click on Transfer and the blog will be transfered.",
		'blog_tools:transfer:form:new_owner' => "Type the name of the new owner",
		'blog_tools:transfer:form:submit' => "Transfer",
		
		// actions
		'blog_tools:action:error:input' => "Incorrect input to perform this action",
		'blog_tools:action:error:guid' => "The given GUID didn't result in an entity",
		'blog_tools:action:error:entity' => "You're not allowed to edit the given entity",
		
		'blog_tools:action:toggle_metadata:error' => "An unknown error occured while editing the entity, please try agian",
		'blog_tools:action:toggle_metadata:success' => "The entity was successfully edited",
		
		
		'blog_tools:action:transfer:error:owner' => "You can't transfer the blog to the same user",
		'blog_tools:action:transfer:error:transfer' => "An unknown error occured while transfering the blog, please try again",
		'blog_tools:action:transfer:success' => "Blog successfully transfered",
		
		'' => "",
	);
	
	add_translation("en", $english);