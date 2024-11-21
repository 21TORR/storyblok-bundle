<?php declare(strict_types=1);

namespace Torr\Storyblok\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Torr\Storyblok\Webhook\Payload\AbstractWebhookPayload;

/**
 * The event, that is dispatched after a webhook from storyblok was received.
 */
final class StoryblokWebhookEvent extends Event
{
	private array $responseData = [];

	/**
	 *
	 */
	public function __construct (
		public readonly AbstractWebhookPayload $payload,
	) {}

	/**
	 * @return $this
	 */
	public function addResponseData (string $key, mixed $value) : self
	{
		$this->responseData[$key] = $value;

		return $this;
	}

	/**
	 *
	 */
	public function getResponseData () : array
	{
		return $this->responseData;
	}
}
