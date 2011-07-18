<?php

	/**
	 * Elgg blog: edit post action
	 * 
	 * @package ElggBlog
	 */

	// Make sure we're logged in (send us to the front page if not)
		gatekeeper();

	// Get input data
		$guid = (int) get_input('blogpost');
		$title = strip_tags(get_input('blogtitle'));
		$body = get_input('blogbody');
		$access = get_input('access_id');
		$tags = get_input('blogtags');
		$comments_on = get_input('comments_select','Off');
		
	// Make sure we actually have permission to edit
		$blog = get_entity($guid);
		if ($blog->getSubtype() == "blog" && $blog->canEdit()) {
	
		// Cache to the session
			
			$_SESSION['user']->blogtitle = $title;
			$_SESSION['user']->blogbody = $body;
			$_SESSION['user']->blogtags = $tags;
			
		// Convert string of tags into a preformatted array
			$tagarray = string_to_tag_array($tags);
			
		// Make sure the title / description aren't blank
			if (empty($title) || empty($body)) {
				register_error(elgg_echo("blog:blank"));
				forward(REFERER);
				
		// Otherwise, save the blog post 
			} else {
				
		// Get owning user
				$owner = get_entity($blog->getOwner());
		// For now, set its access to public (we'll add an access dropdown shortly)
				$blog->access_id = $access;
		// Set its title and description appropriately
				$blog->title = $title;
				$blog->description = $body;
		// Before we can set metadata, we need to save the blog post
				if (!$blog->save()) {
					register_error(elgg_echo("blog:error"));
					forward(REFERER);
				}
		// Now let's add tags. We can pass an array directly to the object property! Easy.
				$blog->clearMetadata('tags');
				if (is_array($tagarray)) {
					$blog->tags = $tagarray;
				}

				$blog->comments_on = $comments_on; //whether the users wants to allow comments or not on the blog post

				// Now see if we have a file icon
				$remove_icon = get_input("remove_icon");
				
				if($remove_icon && ($remove_icon[0] == "remove")){
					
					$prefix = "blogs/".$blog->guid;
					
					$filehandler = new ElggFile();
					$filehandler->owner_guid = $blog->owner_guid;
					$filehandler->setFilename($prefix . ".jpg");
					if($filehandler->exists()){
						$filehandler->delete();
						
						$filehandler->setFilename($prefix."tiny.jpg");
						$filehandler->delete();
				
						$filehandler->setFilename($prefix."small.jpg");
						$filehandler->delete();
						
						$filehandler->setFilename($prefix."medium.jpg");
						$filehandler->delete();
						
						$filehandler->setFilename($prefix."large.jpg");
						$filehandler->delete();
						
						unset($blog->icontime);
					}
				} else {
					if ((isset($_FILES['icon'])) && (substr_count($_FILES['icon']['type'],'image/'))) {
						$prefix = "blogs/".$blog->guid;
					
						$filehandler = new ElggFile();
						$filehandler->owner_guid = $blog->owner_guid;
						$filehandler->setFilename($prefix . ".jpg");
						$filehandler->open("write");
						$filehandler->write(get_uploaded_file('icon'));
						$filehandler->close();
					
						$thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),25,25, true);
						$thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),40,40, true);
						$thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),100,100, true);
						$thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),200,200, false);
						if ($thumbtiny) {
					
							$thumb = new ElggFile();
							$thumb->owner_guid = $blog->owner_guid;
							$thumb->setMimeType('image/jpeg');
					
							$thumb->setFilename($prefix."tiny.jpg");
							$thumb->open("write");
							$thumb->write($thumbtiny);
							$thumb->close();
					
							$thumb->setFilename($prefix."small.jpg");
							$thumb->open("write");
							$thumb->write($thumbsmall);
							$thumb->close();
					
							$thumb->setFilename($prefix."medium.jpg");
							$thumb->open("write");
							$thumb->write($thumbmedium);
							$thumb->close();
					
							$thumb->setFilename($prefix."large.jpg");
							$thumb->open("write");
							$thumb->write($thumblarge);
							$thumb->close();
					
							$blog->icontime = time();
						}
					}	
				}
		// Success message
				system_message(elgg_echo("blog:posted"));
		//add to the river
				add_to_river('river/object/blog/update','update',$_SESSION['user']->guid,$blog->guid);
		// Remove the blog post cache
				//unset($_SESSION['blogtitle']); unset($_SESSION['blogbody']); unset($_SESSION['blogtags']);
				remove_metadata($_SESSION['user']->guid,'blogtitle');
				remove_metadata($_SESSION['user']->guid,'blogbody');
				remove_metadata($_SESSION['user']->guid,'blogtags');
		// Forward to the main blog page
			$page_owner = get_entity($blog->container_guid);
			if ($page_owner instanceof ElggUser)
				$username = $page_owner->username;
			else if ($page_owner instanceof ElggGroup)
				$username = "group:" . $page_owner->guid;
			forward("pg/blog/owner/$username");
					
			}
		
		}
		
?>
