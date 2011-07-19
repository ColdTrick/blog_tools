<?php

	$entity = $vars["entity"];
	
	$form_body = "<div>" . elgg_echo("blog_tools:transfer:description") . "</div>";
	$form_body .= "<br />";
	
	$form_body .= "<div>" . elgg_echo("blog_tools:transfer:form:new_owner") . "</div>";
	$form_body .= elgg_view("input/hidden", array("internalname" => "guid", "value" => $entity->getGUID()));
	$form_body .= elgg_view("input/autocomplete", array("internalname" => "user_guid", "match_on" => "users_of_site"));
	
	$form_body .= "<div>";
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("blog_tools:transfer:form:submit")));
	$form_body .= "</div>";
	
	$form = elgg_view("input/form", array("body" => $form_body,
											"action" => $vars["url"] . "action/blog_tools/transfer"));
	
	echo elgg_view("page_elements/contentwrapper", array("body" => $form));