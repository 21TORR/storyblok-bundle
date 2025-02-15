<?php declare(strict_types=1);

namespace Torr\Storyblok\Field\Data;

final class RichTextAssetLinkData
{
	public function __construct (
		public readonly ?string $uuid,
		public readonly string $url,
		public readonly ?string $anchor,
		public readonly ?string $target,
		public readonly ?array $custom,
	) {}
}
