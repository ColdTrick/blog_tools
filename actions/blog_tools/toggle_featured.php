<?php

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity instanceof ElggBlog || !$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$old = $entity->featured;
if ($old) {
	unset($entity->featured);
	
	$success = elgg_echo('blog_tools:action:toggle_feature:success:unfeature');
	$error = elgg_echo('blog_tools:action:toggle_feature:error:unfeature');
} else {
	$entity->featured = time();
	
	$success = elgg_echo('blog_tools:action:toggle_feature:success:feature');
	$error = elgg_echo('blog_tools:action:toggle_feature:error:feature');
}

if ($old === $entity->featured) {
	return elgg_error_response($error);
}

return elgg_ok_response('', $success);
