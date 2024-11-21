<?php declare(strict_types=1);

namespace Torr\Storyblok\Webhook\Payload;

use Torr\Storyblok\Webhook\Action\WebhookAction;

final readonly class StoryWebhookPayload extends AbstractWebhookPayload
{
	public function __construct (
		WebhookAction $action,
		string $text,
		public int $storyId,
		public string $fullSlug,
	)
	{
		parent::__construct($action, $text);
	}
}
