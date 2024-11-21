<?php declare(strict_types=1);

namespace Torr\Storyblok\Assets\Webhook;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Torr\Storyblok\Assets\Proxy\AssetProxy;
use Torr\Storyblok\Event\StoryblokWebhookEvent;
use Torr\Storyblok\Webhook\Action\WebhookAction;
use Torr\Storyblok\Webhook\Payload\AssetWebhookPayload;

/**
 * @final
 */
readonly class AssetProxyWebhookIntegration
{
	public function __construct (
		private AssetProxy $assetProxy,
	) {}

	/**
	 *
	 */
	#[AsEventListener]
	public function onWebhook (StoryblokWebhookEvent $event) : void
	{
		$payload = $event->payload;

		if (!$payload instanceof AssetWebhookPayload)
		{
			return;
		}

		if (
			WebhookAction::AssetReplaced === $payload->action
			|| WebhookAction::AssetDeleted === $payload->action
		)
		{
			$this->assetProxy->clearStorageFile($payload->assetPath);
		}
	}
}
