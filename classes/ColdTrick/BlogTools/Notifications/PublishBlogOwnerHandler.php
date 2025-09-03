<?php

namespace ColdTrick\BlogTools\Notifications;

use Elgg\Notifications\InstantNotificationEventHandler;

/**
 * Notify the owner of a blog about the publication of their blog
 * due to advanced publication options
 */
class PublishBlogOwnerHandler extends InstantNotificationEventHandler {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		return elgg_echo('blog_tools:notify:publish:subject');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return elgg_echo('blog_tools:notify:publish:subject');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$entity = $this->getEventEntity();
		if (!$entity instanceof \ElggBlog) {
			return parent::getNotificationBody($recipient, $method);
		}
		
		return elgg_echo('blog_tools:notify:publish:message', [
			$entity->getDisplayName(),
			$entity->getURL(),
		]);
	}
}
