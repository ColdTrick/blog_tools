<?php
/**
 * All plugin hooks are bundled here
 */

/**
 * Return the url for a blog icon (if any)
 *
 * @param string $hook        "entity:icon:url"
 * @param string $entity_type "object"
 * @param string $returnvalue the current icon url
 * @param array  $params      supplied params
 *
 * @return string|void
 */
function blog_tools_icon_hook($hook, $entity_type, $returnvalue, $params) {
	
	if (!empty($params) && is_array($params)) {
		$entity = elgg_extract("entity", $params);
		
		if (!empty($entity) && elgg_instanceof($entity, "object", "blog")) {
			$size = elgg_extract("size", $params);
			
			if ($icontime = $entity->icontime) {
				
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getOwnerGUID();
				$filehandler->setFilename("blogs/" . $entity->getGUID() . $size . ".jpg");
				
				if ($filehandler->exists()) {
					$url = elgg_get_site_url() . "blogicon/" . $entity->getGUID() . "/" . $size . "/" . $icontime . ".jpg";
					
					return $url;
				}
			}
		}
	}
}

/**
 * Add some menu items to the entity menu
 *
 * @param string         $hook        "register"
 * @param string         $entity_type "menu:entity"
 * @param ElggMenuItem[] $returnvalue the current menu items
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function blog_tools_entity_menu_setup($hook, $entity_type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity) || !elgg_instanceof($entity, "object", "blog")) {
		return $returnvalue;
	}
	
	// only published blogs
	if ($entity->status == "draft") {
		return $returnvalue;
	}
	
	if (!elgg_in_context("widgets") && elgg_is_admin_logged_in()) {
		$returnvalue[] = ElggMenuItem::factory(array(
			"name" => "blog-feature",
			"text" => elgg_echo("blog_tools:toggle:feature"),
			"href" => "action/blog_tools/toggle_metadata?guid=" . $entity->getGUID() . "&metadata=featured",
			"item_class" => empty($entity->featured) ? "" : "hidden",
			"is_action" => true,
			"priority" => 175
		));
		$returnvalue[] = ElggMenuItem::factory(array(
			"name" => "blog-unfeature",
			"text" => elgg_echo("blog_tools:toggle:unfeature"),
			"href" => "action/blog_tools/toggle_metadata?guid=" . $entity->getGUID() . "&metadata=featured",
			"item_class" => empty($entity->featured) ? "hidden" : "",
			"is_action" => true,
			"priority" => 176
		));
	}
	
	if ($entity->canComment()) {
		$returnvalue[] = ElggMenuItem::factory(array(
			"name" => "comments",
			"text" => elgg_view_icon("speech-bubble"),
			"title" => elgg_echo("comment:this"),
			"href" => $entity->getURL() . "#comments"
		));
	}
	
	return $returnvalue;
}

/**
 * Listen to the blog page handler, to takeover some pages
 *
 * @param string $hook         "route"
 * @param string $type         "blog"
 * @param array  $return_value the current page_handler params
 * @param null   $params       null
 *
 * @return array|bool
 */
function blog_tools_route_blog_hook($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	$page = elgg_extract("segments", $return_value);
	if (!empty($page)) {
		
		switch ($page[0]) {
			case "owner":
				$user = get_user_by_username($page[1]);
				if (!empty($user)) {
					$result = false;
					// push all blogs breadcrumb
					elgg_push_breadcrumb(elgg_echo("blog:blogs"), "blog/all");
					
					set_input("owner_guid", $user->guid);
					include(dirname(dirname(__FILE__)) . "/pages/owner.php");
					break;
				}
			case "read": // Elgg 1.7 compatibility
			case "view":
				if (!elgg_is_logged_in()) {
					$setting = elgg_get_plugin_setting("advanced_gatekeeper", "blog_tools");
					if ($setting != "no") {
						if (isset($page[1]) && !get_entity($page[1])) {
							gatekeeper();
						}
					}
				}
				
				set_input("guid", $page[1]); // to be used in the blog_tools/full/related view
				break;
			case "add":
			case "edit":
				$result = false;
				// push all blogs breadcrumb
				elgg_push_breadcrumb(elgg_echo("blog:blogs"), "blog/all");
				
				set_input("page_type", $page[0]);
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				if (isset($page[2])) {
					set_input("revision", $page[2]);
				}
				
				include(dirname(dirname(__FILE__)) . "/pages/edit.php");
				break;
			case "featured":
				$result = false;
								
				include(dirname(dirname(__FILE__)) . "/pages/featured.php");
				break;
		}
	}
	
	return $result;
}

/**
 * add functionality to the livesearch
 *
 * @param string $hook         'route'
 * @param string $type         'livesearch'
 * @param array  $return_value the page_handler params
 * @param null   $params       null
 *
 * @return array|void
 */
function blog_tools_route_livesearch_hook($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (!elgg_is_logged_in()) {
		return false;
	}
	
	$q = get_input("term");
	if (empty($q)) {
		return false;
	}
	
	$match_on = get_input("match_on");
	$limit = (int) get_input("limit", 10);
	if ($limit < 1) {
		$limit = 10;
	}
	
	if (!empty($match_on) && ($match_on == "users_of_site")) {
		$result = false;
		
		$q = sanitise_string($q);
		
		$return = array();
		
		$options = array(
			"type" => "user",
			"relationship" => "member_of_site",
			"relationship_guid" => get_config("site_guid"),
			"inverse_relationship" => true,
			"limit" => $limit,
			"joins" => array("JOIN " . get_config("dbprefix") . "users_entity ue ON e.guid = ue.guid"),
			"wheres" => array("(ue.username LIKE '%" . $q . "%' OR ue.name LIKE '%" . $q . "%')")
		);
		
		$users = elgg_get_entities_from_relationship($options);
		if (!empty($users)) {
			foreach ($users as $user) {
				$json = json_encode(array(
					"type" => "user",
					"name" => $user->name,
					"desc" => $user->username,
					"icon" => "<img class='livesearch_icon' src='" . $user->getIcon("tiny") . "' />",
					"guid" => $user->getGUID()
				));
				
				$return[$user->name . rand(1,100)] = $json;
			}
		}
		
		ksort($return);
		echo implode("\n", $return);
	}
	
	return $result;
}

/**
 * Support widget urls for Widget Manager
 *
 * @param string $hook         'widget_url'
 * @param string $type         'widget_manager'
 * @param string $return_value the current widget url
 * @param array  $params       supplied params
 *
 * @return string
 */
function blog_tools_widget_url_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (!$result && !empty($params) && is_array($params)) {
		$widget = elgg_extract("entity", $params);
			
		if (!empty($widget) && elgg_instanceof($widget, "object", "widget")) {
			switch ($widget->handler) {
				case "index_blog":
					$result = "blog/all";
					break;
				case "blog":
					$owner = $widget->getOwnerEntity();
					if (elgg_instanceof($owner, "user")) {
						$result = "blog/owner/" . $owner->username;
					} elseif (elgg_instanceof($owner, "group")) {
						$result = "blog/group/" . $owner->getGUID() . "/all";
					}
					break;
			}
		}
	}
	
	return $result;
}

/**
 * Publish blogs based on advanced publication options
 *
 * @param string $hook         'cron'
 * @param string $type         'daily'
 * @param string $return_value optional stdout text
 * @param array  $params       supplied params
 *
 * @return void
 */
function blog_tools_daily_cron_hook($hook, $type, $return_value, $params) {
	
	// only do if this is configured
	if (blog_tools_use_advanced_publication_options()) {
		$dbprefix = elgg_get_config("dbprefix");
		$publication_id = elgg_get_metastring_id("publication_date");
		$expiration_id = elgg_get_metastring_id("expiration_date");
		
		$time = elgg_extract("time", $params, time());
		
		$publish_options = array(
			"type" => "object",
			"subtype" => "blog",
			"limit" => false,
			"joins" => array(
				"JOIN " . $dbprefix . "metadata mdtime ON e.guid = mdtime.entity_guid",
				"JOIN " . $dbprefix . "metastrings mstime ON mdtime.value_id = mstime.id"
			),
			"metadata_name_value_pairs" => array(
				array(
					"name" => "status",
					"value" => "draft"
				)
			),
			"wheres" => array("((mdtime.name_id = " . $publication_id . ") AND (DATE(mstime.string) = DATE(NOW())))")
		);
		
		$unpublish_options = array(
			"type" => "object",
			"subtype" => "blog",
			"limit" => false,
			"joins" => array(
				"JOIN " . $dbprefix . "metadata mdtime ON e.guid = mdtime.entity_guid",
				"JOIN " . $dbprefix . "metastrings mstime ON mdtime.value_id = mstime.id"
			),
			"metadata_name_values_pairs" => array(
				array(
					"name" => "status",
					"value" => "published"
				)
			),
			"wheres" => array("((mdtime.name_id = " . $expiration_id . ") AND (DATE(mstime.string) = DATE(NOW())))")
		);
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		// get unpublished blogs that need to be published
		$entities = elgg_get_entities_from_metadata($publish_options);
		if (!empty($entities)) {
			foreach ($entities as $entity) {
				// add river item
				elgg_create_river_item(array(
					"view" => "river/object/blog/create",
					"action_type" => "create",
					"subject_guid" => $entity->getOwnerGUID(),
					"object_guid" => $entity->getGUID(),
				));
				
				// set correct time created
				$entity->time_created = $time;
				
				// publish blog
				$entity->status = "published";
				
				// notify owner
				notify_user($entity->getOwnerGUID(),
							$entity->site_guid,
							elgg_echo("blog_tools:notify:publish:subject"),
							elgg_echo("blog_tools:notify:publish:message", array(
								$entity->title,
								$entity->getURL()
							))
				);
				
				// save everything
				$entity->save();
			}
		}
		
		// get published blogs that need to be unpublished
		$entities = elgg_get_entities_from_metadata($unpublish_options);
		if (!empty($entities)) {
			foreach ($entities as $entity) {
				// remove river item
				elgg_delete_river(array(
					"object_guid" => $entity->getGUID(),
					"action_type" => "create",
				));
				
				// unpublish blog
				$entity->status = "draft";
				
				// notify owner
				notify_user($entity->getOwnerGUID(),
							$entity->site_guid,
							elgg_echo("blog_tools:notify:expire:subject"),
							elgg_echo("blog_tools:notify:expire:message", array(
								$entity->title,
								$entity->getURL()
							))
				);
				
				// save everything
				$entity->save();
			}
		}
		
		// reset access
		elgg_set_ignore_access($ia);
	}
}

/**
 * Add or remove widgets based on the group tool option
 *
 * @param string $hook         'group_tool_widgets'
 * @param string $type         'widget_manager'
 * @param array  $return_value current enable/disable widget handlers
 * @param array  $params       supplied params
 *
 * @return array
 */
function blog_tools_tool_widgets_handler($hook, $type, $return_value, $params) {

	if (!empty($params) && is_array($params)) {
		$entity = elgg_extract("entity", $params);

		if (!empty($entity) && elgg_instanceof($entity, "group")) {
			if (!is_array($return_value)) {
				$return_value = array();
			}
				
			if (!isset($return_value["enable"])) {
				$return_value["enable"] = array();
			}
			if (!isset($return_value["disable"])) {
				$return_value["disable"] = array();
			}
				
			// check different group tools for which we supply widgets
			if ($entity->blog_enable == "yes") {
				$return_value["enable"][] = "blog";
			} else {
				$return_value["disable"][] = "blog";
			}
		}
	}

	return $return_value;
}