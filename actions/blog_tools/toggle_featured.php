<?php

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity instanceof \ElggBlog || !$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

if (!empty($entity->featured)) {
	unset($entity->featured);
	
	return elgg_ok_response('', elgg_echo('blog_tools:action:toggle_feature:success:unfeature'));
}

$entity->featured = time();
	
return elgg_ok_response('', elgg_echo('blog_tools:action:toggle_feature:success:feature'));
