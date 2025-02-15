<?php declare(strict_types=1);

namespace Torr\Storyblok\Component\Filter;

final class ComponentFilter
{
	/**
	 */
	public function __construct (
		/** @var list<string|\BackedEnum> */
		public readonly array $tags = [],
		/** @var list<string|\BackedEnum> */
		public readonly array $components = [],
	) {}

	/**
	 */
	public static function tags (string|\BackedEnum ...$tags) : self
	{
		return new self(tags: array_values($tags));
	}

	/**
	 */
	public static function keys (string|\BackedEnum ...$components) : self
	{
		return new self(components: array_values($components));
	}
}
