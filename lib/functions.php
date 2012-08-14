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
							$fh->delete();
						}
					}
				}
				
				unset($blog->icontime);
				$result = true;
			} else {
				$result = true;
			}
		}
		
		return $result;
	}

	function blog_tools_use_advanced_publication_options(){
		static $result;
		
		if(!isset($result)){
			$result = false;
			
			if(($setting = elgg_get_plugin_setting("advanced_publication", "blog_tools")) && ($setting == "yes")){
				$result = true;
			}
		}
		
		return $result;
	}