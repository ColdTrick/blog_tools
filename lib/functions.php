<?php

	global $BLOG_TOOLS_PAGE_HANDLER_BACKUP;
	$BLOG_TOOLS_PAGE_HANDLER_BACKUP = array();
	
	function blog_tools_extend_page_handler($handler, $function){
		global $BLOG_TOOLS_PAGE_HANDLER_BACKUP;
		global $CONFIG;
		
		$result = false;
		
		if(!empty($handler) && !empty($function) && is_callable($function)){
			if(isset($CONFIG->pagehandler) && array_key_exists($handler, $CONFIG->pagehandler)){
				// backup original page handler
				$BLOG_TOOLS_PAGE_HANDLER_BACKUP[$handler] = $CONFIG->pagehandler[$handler];
				// register new handler
				elgg_register_page_handler($handler, $function);
				$result = true;
			} else {
				elgg_register_page_handler($handler, $function);
				$result = true;
			}
		}
		
		return $result;
	}
	
	function blog_tools_fallback_page_handler($page, $handler){
		global $BLOG_TOOLS_PAGE_HANDLER_BACKUP;
		
		$result = false;
		
		if(!empty($handler)){
			if(array_key_exists($handler, $BLOG_TOOLS_PAGE_HANDLER_BACKUP)){
				if(is_callable($BLOG_TOOLS_PAGE_HANDLER_BACKUP[$handler])){
					$function = $BLOG_TOOLS_PAGE_HANDLER_BACKUP[$handler];
					
					$result = $function($page, $handler);
					
					if($result !== false){
						$result = true;
					}
				}
			}
		}
		
		return $result;
	}
	
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
						
						if($fh->exitst()){
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
