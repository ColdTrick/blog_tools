<?php

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity instanceof ElggBlog || !$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$old = $entity->featured;
if ($old) {
	unset($entity->featured);
} else {
	$entity->featured = time();
}

if ($old === $entity->featured) {
	return elgg_error_response(elgg_echo('save:fail'));
}

return elgg_ok_response('', elgg_echo('save:success'));
