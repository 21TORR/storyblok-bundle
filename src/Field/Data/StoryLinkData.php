<?php declare(strict_types=1);

namespace Torr\Storyblok\Field\Data;

final class StoryLinkData
{
	public function __construct (
		public readonly string $fullSlug,
		public readonly ?string $anchor,
	) {}
}
