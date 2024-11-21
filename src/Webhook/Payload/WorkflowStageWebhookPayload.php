<?php declare(strict_types=1);

namespace Torr\Storyblok\Webhook\Payload;

use Torr\Storyblok\Webhook\Action\WebhookAction;

final readonly class WorkflowStageWebhookPayload extends AbstractWebhookPayload
{
	/**
	 *
	 */
	public function __construct (
		WebhookAction $action,
		string $text,
		public int $storyId,
		public string $workflowName,
		public string $workflowStageName,
	)
	{
		parent::__construct($action, $text);
	}
}
