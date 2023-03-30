<?php

namespace ColdTrick\BlogTools\Upgrades;

use Elgg\Upgrade\AsynchronousUpgrade;
use Elgg\Upgrade\Result;

class MoveHeaderIcons extends AsynchronousUpgrade {

	/**
	 * {@inheritdoc}
	 */
	public function getVersion(): int {
		return 2023032800;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function needsIncrementOffset(): bool {
		return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function shouldBeSkipped(): bool {
		return empty($this->countItems());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function countItems(): int {
		return elgg_count_entities($this->getOptions());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function run(Result $result, $offset): Result {
		$blogs = elgg_get_entities($this->getOptions(['offset' => $offset]));
		/* @var $blog \ElggBlog */
		foreach ($blogs as $blog) {
			$old_icon = $blog->getIcon('master', 'icon');
			if ($old_icon->exists()) {
				$coords = [
					'x1' => $blog->x1,
					'y1' => $blog->y1,
					'x2' => $blog->x2,
					'y2' => $blog->y2,
				];
				
				$blog->saveIconFromElggFile($old_icon, 'header', $coords);
			}
			
			$blog->deleteIcon('icon');
			
			$result->addSuccesses();
		}
		
		return $result;
	}
	
	/**
	 * Get options for elgg_get_entities
	 *
	 * @param array $options additional options
	 *
	 * @return array
	 */
	protected function getOptions(array $options = []) {
		$defaults = [
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => 50,
			'batch' => true,
			'metadata_name' => 'icontime',
		];
		
		return array_merge($defaults, $options);
	}
}
