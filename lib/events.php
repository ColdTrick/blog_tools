<?php

	function blog_tools_delete_handler($event, $type, $object){
		
		if(elgg_instanceof($object, "object", "blog", "ElggBlog")){
			blog_tools_remove_blog_icon($object);
		}
	}