<?php declare(strict_types=1);

namespace Torr\Storyblok\Webhook\Payload;

use Torr\Storyblok\Webhook\Action\WebhookAction;

final readonly class UserWebhookPayload extends AbstractWebhookPayload
{
	public function __construct (
		WebhookAction $action,
		string $text,
		public int $userId,
	)
	{
		parent::__construct($action, $text);
	}
}
