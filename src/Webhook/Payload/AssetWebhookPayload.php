<?php declare(strict_types=1);

namespace Torr\Storyblok\Webhook\Payload;

use Torr\Storyblok\Webhook\Action\WebhookAction;

final readonly class AssetWebhookPayload extends AbstractWebhookPayload
{
	public function __construct (
		WebhookAction $action,
		string $text,
		public int $assetId,
		public string $assetPath,
	)
	{
		parent::__construct($action, $text);
	}
}
