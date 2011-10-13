<?php

	function blog_tools_delete_handler($event, $type, $object){
		
		if(!empty($object) && ($object instanceof ElggObject)){
			if($object->getSubtype() == "blog"){
				$sizes = array("tiny", "small", "medium", "large");
				$prefix = "blogs/" . $object->getGUID();
				
				$fh = new ElggFile();
				$fh->owner_guid = $object->getOwner();
				$fh->setFilename($prefix . ".jpg");
				
				if($fh->exists()){
					$fh->delete();
					
					foreach($sizes as $size){
						$fh->setFilename($prefix . $size . ".jpg");
						$fh->delete();
					}
				}
			}
		}
	}