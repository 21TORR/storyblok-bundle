<?php declare(strict_types=1);

namespace Torr\Storyblok\Hosting;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Torr\Hosting\Event\ValidateAppEvent;
use Torr\Storyblok\Api\ContentApi;
use Torr\Storyblok\Exception\Config\InvalidConfigException;

/**
 * @final
 */
readonly class ValidateStoryblokConfigListener
{
	/**
	 *
	 */
	public function __construct (
		private ContentApi $contentApi,
	) {}

	/**
	 *
	 */
	#[AsEventListener]
	public function onValidateApp (ValidateAppEvent $event) : void
	{
		$io = $event->io;
		$io->write("• Checking Storyblok configuration ... ");

		try
		{
			$this->contentApi->getSpaceInfo();
			$io->writeln("<fg=green>valid</>");
		}
		catch (InvalidConfigException)
		{
			$io->writeln("<fg=red>invalid</>");
			$event->markAppAsInvalid("Storyblok Config");
		}
	}
}
