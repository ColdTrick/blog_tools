<?php

$guid = (int) get_input('guid');
$metadata = get_input('metadata');

if (empty($guid) || empty($metadata)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof ElggBlog || !$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$old = $entity->$metadata;

if (empty($entity->$metadata)) {
	$entity->$metadata = true;
} else {
	unset($entity->$metadata);
}

if ($old === $entity->$metadata) {
	return elgg_error_response(elgg_echo('save:fail'));
}

return elgg_ok_response('', elgg_echo('save:success'));
