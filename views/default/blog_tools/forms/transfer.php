<?php

	$entity = $vars["entity"];
	
	$form_body = "<div>" . elgg_echo("blog_tools:transfer:description") . "</div>";
	
	$form_body .= "<div>";
	$form_body .= elgg_echo("blog_tools:transfer:form:new_owner");
	$form_body .= elgg_view("input/hidden", array("name" => "guid", "value" => $entity->getGUID()));
	$form_body .= elgg_view("input/autocomplete", array("name" => "user_guid", "match_on" => "users_of_site"));
	$form_body .= "</div>";
	
	$form_body .= "<div>";
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("blog_tools:transfer:form:submit")));
	$form_body .= "</div>";
	
	$form = elgg_view("input/form", array("body" => $form_body,
											"action" => $vars["url"] . "action/blog_tools/transfer"));
	
	echo $form;
// 	echo elgg_view("page_elements/contentwrapper", array("body" => $form));