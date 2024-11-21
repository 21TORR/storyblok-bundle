<?php declare(strict_types=1);

namespace Torr\Storyblok\Webhook\Payload;

use Torr\Storyblok\Webhook\Action\WebhookAction;

final readonly class DatasourceEntryWebhookPayload extends AbstractWebhookPayload
{
	public function __construct (
		WebhookAction $action,
		string $text,
		public string $datasourceSlug,
	)
	{
		parent::__construct($action, $text);
	}
}
