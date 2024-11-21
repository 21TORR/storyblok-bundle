<?php declare(strict_types=1);

namespace Torr\Storyblok\Config;

use Torr\Storyblok\Exception\Config\MissingConfigException;

final readonly class StoryblokConfig
{
	/**
	 */
	public function __construct (
		private ?int $spaceId = null,
		private ?string $managementToken = null,
		private ?string $contentToken = null,
		private int $localeLevel = 0,
		public ?string $webhookSecret = null,
		public bool $allowUrlWebhookSecret = false,
	) {}

	/**
	 */
	public function getSpaceId () : int
	{
		return $this->spaceId
			?? throw new MissingConfigException("No storyblok.space_id configured.");
	}

	/**
	 */
	public function getManagementToken () : string
	{
		return $this->managementToken
			?? throw new MissingConfigException("No storyblok.management_token configured.");
	}

	/**
	 */
	public function getContentToken () : string
	{
		return $this->contentToken
			?? throw new MissingConfigException("No storyblok.content_token configured.");
	}

	/**
	 */
	public function getStoryblokSpaceUrl () : string
	{
		return \sprintf("https://app.storyblok.com/#/me/spaces/%d/dashboard", $this->getSpaceId());
	}

	/**
	 * Returns the slug level, on which the locales are defined.
	 * 0-based
	 */
	public function getLocaleLevel () : int
	{
		return $this->localeLevel;
	}
}
