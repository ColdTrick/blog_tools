<?php

	function blog_tools_remove_blog_icon(ElggBlog $blog){
		$result = false;
		
		if(!empty($blog) && elgg_instanceof($blog, "object", "blog", "ElggBlog")){
			if(!empty($blog->icontime)){
				if($icon_sizes = elgg_get_config("icon_sizes")){
					$fh = new ElggFile();
					$fh->owner_guid = $blog->getOwnerGUID();
					
					$prefix = "blogs/" . $blog->getGUID();
					
					foreach($icon_sizes as $name => $info){
						$fh->setFilename($prefix . $name . ".jpg");
						
						if($fh->exists()){
							if($fh->delete()){
								$result = true;
							}
						}
					}
				}
				
				if($result){
					unset($blog->icontime);
				}
			} else {
				$result = true;
			}
		}
		
		return $result;
	}
