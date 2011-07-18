<?php 
	global $CONFIG;

	$guid = (int) get_input("guid");
	$size = strtolower(get_input("size"));
	
	if (!in_array($size,array("large","medium","small","tiny","master","topbar"))) {
		$size = "medium";
	}
	
	$success = false;
	
	if($blog = get_entity($guid)) {
		
		$filehandler = new ElggFile();
		$filehandler->owner_guid = $blog->getOwner();
		$filehandler->setFilename("blogs/" . $blog->getGUID(). $size . ".jpg");
		
		if ($filehandler->exists()) {
			if ($contents = $filehandler->grabFile()) {
				$success = true;
			} 
		}
	}
	
	if (!$success) {
		$contents = @file_get_contents($CONFIG->path. "_graphics/icons/default/{$size}.png");
	}
	
	header("Content-type: image/jpeg");
	header("Expires: " . date("r", time() + 864000));
	header("Pragma: public");
	header("Cache-Control: public");
	header("Content-Length: " . strlen($contents));
	
	echo $contents;
	