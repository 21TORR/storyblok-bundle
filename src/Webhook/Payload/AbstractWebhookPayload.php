<?php declare(strict_types=1);

namespace Torr\Storyblok\Webhook\Payload;

use Torr\Storyblok\Webhook\Action\WebhookAction;

abstract readonly class AbstractWebhookPayload
{
	public function __construct (
		public WebhookAction $action,
		public string $text,
	) {}
}
