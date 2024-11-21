<?php declare(strict_types=1);

namespace Torr\Storyblok\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Torr\Cli\Console\Style\TorrStyle;
use Torr\Storyblok\Assets\Proxy\AssetProxy;

/**
 * @final
 */
#[AsCommand(
	"storyblok:assets:clear-proxy-storage",
	description: "Clear all proxied asset files from storage.",
)]
class ClearAssetProxyStorageCommand extends Command
{
	/**
	 */
	public function __construct (
		private AssetProxy $assetProxy,
	)
	{
		parent::__construct();
	}

	/**
	 *
	 */
	#[\Override]
	protected function execute (InputInterface $input, OutputInterface $output) : int
	{
		$io = new TorrStyle($input, $output);
		$io->title("Storyblok: Clear Asset Proxy Storage");

		$this->assetProxy->clearCompleteStorage();

		$io->success("Done");

		return self::SUCCESS;
	}
}
