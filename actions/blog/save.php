<?php
/**
 * Save blog entity
 *
 * @package Blog
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('blog');

// save or preview
$save = (bool)get_input('save');

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

// edit or create a new entity
$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'blog') && $entity->canEdit()) {
		$blog = $entity;
	} else {
		register_error(elgg_echo('blog:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $blog->description;
	$new_post = $blog->new_post;
} else {
	$blog = new ElggBlog();
	$blog->subtype = 'blog';
	$new_post = TRUE;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $blog->status;

// set defaults and required values.
$values = array(
	'title' => '',
	'description' => '',
	'status' => 'draft',
	'access_id' => ACCESS_DEFAULT,
	'comments_on' => 'On',
	'excerpt' => '',
	'tags' => '',
	'container_guid' => (int)get_input('container_guid'),
);

// fail if a required entity isn't set
$required = array('title', 'description');

// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	$value = get_input($name, $default);

	if (in_array($name, $required) && empty($value)) {
		$error = elgg_echo("blog:error:missing:$name");
	}

	if ($error) {
		break;
	}

	switch ($name) {
		case 'tags':
			if ($value) {
				$values[$name] = string_to_tag_array($value);
			} else {
				unset ($values[$name]);
			}
			break;

		case 'excerpt':
			if ($value) {
				$value = elgg_get_excerpt($value);
			} else {
				$value = elgg_get_excerpt($values['description']);
			}
			$values[$name] = $value;
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				if (can_write_to_container($user->getGUID(), $value)) {
					$values[$name] = $value;
				} else {
					$error = elgg_echo("blog:error:cannot_write_to_container");
				}
			} else {
				unset($values[$name]);
			}
			break;

		// don't try to set the guid
		case 'guid':
			unset($values['guid']);
			break;

		default:
			$values[$name] = $value;
			break;
	}
}

// if preview, force status to be draft
if ($save == false) {
	$values['status'] = 'draft';
}

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
		if (FALSE === ($blog->$name = $value)) {
			$error = elgg_echo('blog:error:cannot_save' . "$name=$value");
			break;
		}
	}
}

// only try to save base entity if no errors
if (!$error) {
	if ($blog->save()) {
		// handle icon upload
		if(get_input("remove_icon") == "yes"){
			// remove existing icons
			$sizes = array("tiny", "small", "medium", "large");
			$prefix = "blogs/" . $blog->getGUID();
			
			$fh = new ElggFile();
			$fh->owner_guid  = $blog->getOwner();
			$fh->setFilename($prefix . ".jpg");
			
			if($fh->exists()){
				$fh->delete();
				
				foreach($sizes as $size){
					$fh->setFilename($prefix . $size . ".jpg");
					$fh->delete();
				}
			}
			
			$blog->clearMetaData("icontime");
		} elseif(($icon_file = get_uploaded_file("icon")) && substr_count($_FILES["icon"]["type"], "image/")){
			// create icon
			$prefix = "blogs/" . $blog->getGUID();
			
			$fh = new ElggFile();
			$fh->owner_guid = $blog->getOwner();
			$fh->setFilename($prefix . ".jpg");
			$fh->open("write");
			$fh->write($icon_file);
			$fh->close();
			
			$tiny = get_resized_image_from_uploaded_file("icon", 25, 25, true);
			$small = get_resized_image_from_uploaded_file("icon", 40, 40, true);
			$medium = get_resized_image_from_uploaded_file("icon", 100, 100, true);
			$large = get_resized_image_from_uploaded_file("icon", 200, 200);
			
			if($tiny){
				$fh->setMimeType("image/jpeg");
				
				$fh->setFilename($prefix . "tiny.jpg");
				$fh->open("write");
				$fh->write($tiny);
				$fh->close();
				
				$fh->setFilename($prefix . "small.jpg");
				$fh->open("write");
				$fh->write($small);
				$fh->close();
				
				$fh->setFilename($prefix . "medium.jpg");
				$fh->open("write");
				$fh->write($medium);
				$fh->close();
				
				$fh->setFilename($prefix . "large.jpg");
				$fh->open("write");
				$fh->write($large);
				$fh->close();
				
				$blog->icontime = time();
			}
		}
		
		// remove sticky form entries
		elgg_clear_sticky_form('blog');

		// remove autosave draft if exists
		$blog->clearAnnotations('blog_auto_save');

		// no longer a brand new post.
		$blog->clearMetadata('new_post');

		// if this was an edit, create a revision annotation
		if (!$new_post && $revision_text) {
			$blog->annotate('blog_revision', $revision_text);
		}

		system_message(elgg_echo('blog:message:saved'));

		$status = $blog->status;
		
		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft') && $status == 'published') {
			add_to_river('river/object/blog/create', 'create', elgg_get_logged_in_user_guid(), $blog->getGUID());

			if ($guid) {
				$blog->time_created = time();
				$blog->save();
			}
		} elseif ($old_status == 'published' && $status == 'draft') {
			elgg_delete_river(array(
				'object_guid' => $blog->guid,
				'action_type' => 'create',
			));
		}

		if ($blog->status == 'published' || $save == false) {
			forward($blog->getURL());
		} else {
			forward("blog/edit/$blog->guid");
		}
	} else {
		register_error(elgg_echo('blog:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}