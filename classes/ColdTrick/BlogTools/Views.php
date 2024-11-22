<?php

namespace ColdTrick\BlogTools;

use Elgg\Values;
use Elgg\ViewsService;

/**
 * Views related callbacks
 */
class Views {
	
	/**
	 * Prevent the blog/sidebar/archives from being drawn
	 *
	 * @param \Elgg\Event $event 'view_vars', 'blog/sidebar/archives'
	 *
	 * @return null|array
	 */
	public static function preventBlogArchiveSidebar(\Elgg\Event $event): ?array {
		if (!(bool) elgg_get_plugin_setting('archive_menu', 'blog_tools')) {
			return null;
		}
		
		$return = $event->getValue();
		$return[ViewsService::OUTPUT_KEY] = '';
		
		return $return;
	}
	
	/**
	 * Add the future publication date to the imprint of a blog
	 *
	 * @param \Elgg\Event $event 'view_vars', 'object/elements/imprint/contents'
	 *
	 * @return null|array
	 */
	public static function addPublicationDateImprint(\Elgg\Event $event): ?array {
		$vars = $event->getValue();
		$entity = elgg_extract('entity', $vars);
		if (!$entity instanceof \ElggBlog || !$entity->canEdit()) {
			return null;
		}
		
		if (!isset($entity->publication) || $entity->publication < time()) {
			return null;
		}
		
		$dt = Values::normalizeTime($entity->publication);
		
		$vars['imprint'][] = [
			'icon_name' => 'calendar-alt',
			'content' => elgg_format_element('span', [
				'title' => elgg_echo('blog_tools:imprint:publication', [$dt->formatLocale(elgg_echo('friendlytime:date_format'))]),
			], elgg_view('output/date', [
				'value' => $entity->publication,
				'format' => elgg_echo('friendlytime:date_format'),
			])),
		];
		
		return $vars;
	}
}
