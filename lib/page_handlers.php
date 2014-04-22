<?php

	function blog_tools_icon_handler($page) {
		// The username should be the file we"re getting
		if (isset($page[0])) {
			set_input("guid",$page[0]);
		}
		if (isset($page[1])) {
			set_input("size",$page[1]);
		}
	
		// Include the standard profile index
		include(dirname(dirname(__FILE__)) . "/pages/icon.php");
		return true;
	}
	