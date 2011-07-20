<?php

	/**
	 * Elgg blog listing
	 * 
	 * @package ElggBlog
 	*/

	$entity = $vars["entity"];
	$owner = $entity->getOwnerEntity();
	
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);

	$icon = elgg_view("profile/icon", array('entity' => $owner,
											'size' => 'small'));
	
	$info = "<p>" . elgg_echo('blog') . ": ";
	$info .= elgg_view("output/url", array("href" => $entity->getURL(), "text" => $entity->title));
	$info .= "</p>";
	
	$info .= "<p class='owner_timestamp'>";
	$info .= elgg_view("output/url", array("href" => $owner->getURL(), "text" => $owner->name));
	$info .= "&nbsp;" . $friendlytime;
	$info .= "</p>";
	
	echo elgg_view_listing($icon, $info);
