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
	
	function blog_tools_blog_page_handler($page, $handler){
	
		switch($page[0]){
			case "add":
			case "edit":
				set_input("page_type", $page[0]);
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
				if(isset($page[2])){
					set_input("revision", $page[2]);
				}
				
				include(dirname(dirname(__FILE__)) . "/pages/edit.php");
				break;
			case "transfer":
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
	
				include(dirname(dirname(__FILE__)) . "/pages/transfer.php");
				break;
			default:
				return blog_tools_fallback_page_handler($page, $handler);
			break;
		}
		
		return true;
	}
	
	function blog_tools_livesearch_page_handler($page, $handler){
		global $CONFIG;
		
		if(!elgg_is_logged_in()){
			exit();
		}
		
		if(!($q = get_input("term"))){
			exit();
		}
		
		$match_on = get_input("match_on");
		$limit = (int) get_input("limit", 10);
		if($limit < 1){
			$limit = 10;
		}
		
		if(!empty($match_on) && ($match_on == "users_of_site")){
			$q = sanitise_string($q);
			
			$result = array();
			
			$options = array(
				"type" => "user",
				"relationship" => "member_of_site",
				"relationship_guid" => $CONFIG->site_guid,
				"inverse_relationship" => true,
				"limit" => $limit,
				"joins" => array("JOIN " . $CONFIG->dbprefix . "users_entity ue ON e.guid = ue.guid"),
				"wheres" => array("(ue.username LIKE '%" . $q . "%' OR ue.name LIKE '%" . $q . "%')")
			);
			
			if($users = elgg_get_entities_from_relationship($options)){
				foreach($users as $user){
					$json = json_encode(array(
						'type' => 'user',
						'name' => $user->name,
						'desc' => $user->username,
						'icon' => '<img class="livesearch_icon" src="' . $user->getIcon('tiny') . '" />',
						'guid' => $user->getGUID()
					));
					
					$result[$user->name . rand(1,100)] = $json;
				}
			}
			
			ksort($result);
			echo implode($result, "\n");
		} else {
			blog_tools_fallback_page_handler($page, $handler);
		}
		
		exit();
	}