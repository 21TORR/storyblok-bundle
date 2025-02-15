<?php declare(strict_types=1);

namespace Torr\Storyblok\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class StoryblokBundleConfiguration implements ConfigurationInterface
{
	/**
	 * @inheritDoc
	 */
	public function getConfigTreeBuilder () : TreeBuilder
	{
		$treeBuilder = new TreeBuilder("storyblok");

		$treeBuilder->getRootNode()
			->children()
				->integerNode("space_id")
					->defaultNull()
				->end()
				->scalarNode("management_token")
					->defaultNull()
				->end()
				->scalarNode("content_token")
					->defaultNull()
				->end()
				->integerNode("locale_level")
					->defaultValue(0)
					->info("The slug level that includes the locales (0-based).")
				->end()
				->arrayNode("webhook")
					->addDefaultsIfNotSet()
					->children()
						->scalarNode("secret")
							->info("The secret that is configured in the storyblok webhook")
							->defaultNull()
						->end()
						->booleanNode("allow_url_secret")
							->info("Allows to send the secret via the URL parameter if the proper secrets are not supported. Should be disabled as soon as possible and after disabling, you should rotate the secrets.")
							->defaultFalse()
						->end()
					->end()
				->end()
			->end();

		return $treeBuilder;
	}
}
