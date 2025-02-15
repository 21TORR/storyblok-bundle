<?php declare(strict_types=1);

namespace Torr\Storyblok\Manager;

use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Torr\Storyblok\Component\AbstractComponent;
use Torr\Storyblok\Exception\Component\UnknownComponentKeyException;
use Torr\Storyblok\Exception\Component\UnknownStoryTypeException;
use Torr\Storyblok\Story\Story;

/**
 * @final
 */
class ComponentManager
{
	/**
	 */
	public function __construct (
		/** @var ServiceLocator<AbstractComponent> */
		#[AutowireLocator(services: 'storyblok.component.definition', defaultIndexMethod: 'getKey')]
		private readonly ServiceLocator $components,
	) {}

	/**
	 * @return list<AbstractComponent>
	 */
	public function getAllComponents () : array
	{
		$components = array_map(
			fn (string $key) => $this->getComponent($key),
			array_keys($this->components->getProvidedServices()),
		);

		usort(
			$components,
			static fn (AbstractComponent $left, AbstractComponent $right) => strnatcmp($left->getDisplayName(), $right->getDisplayName()),
		);

		return $components;
	}

	/**
	 * Returns the first component that creates a story of the given type
	 *
	 * @template TStory of Story
	 *
	 * @param class-string<TStory> $storyType
	 *
	 * @throws UnknownStoryTypeException
	 */
	public function getComponentByStoryType (string $storyType) : AbstractComponent
	{
		foreach ($this->getAllComponents() as $component)
		{
			if ($component->getStoryClass() === $storyType)
			{
				return $component;
			}
		}

		throw new UnknownStoryTypeException(\sprintf(
			"Found no component generating a story of type '%s'",
			$storyType,
		));
	}

	/**
	 * Returns the component keys for all components with any of the given tags
	 *
	 * @param list<string|\BackedEnum> $tags
	 *
	 * @return string[]
	 */
	public function getComponentKeysForTags (array $tags) : array
	{
		$matches = [];

		$normalizeTag = static fn (string|\BackedEnum $tag) => $tag instanceof \BackedEnum
			? $tag->value
			: $tag;

		$normalizedTags = array_map($normalizeTag, $tags);

		foreach ($this->getAllComponents() as $component)
		{
			$componentTags = array_map($normalizeTag, $component->getTags());

			if (!empty(array_intersect($normalizedTags, $componentTags)))
			{
				$matches[] = $component::getKey();
			}
		}

		return $matches;
	}

	/**
	 * Gets the component by key
	 *
	 * @throws UnknownComponentKeyException
	 */
	public function getComponent (string $key) : AbstractComponent
	{
		try
		{
			$component = $this->components->get($key);
			\assert($component instanceof AbstractComponent);

			return $component;
		}
		catch (ServiceNotFoundException $exception)
		{
			throw new UnknownComponentKeyException(
				message: \sprintf(
					"Unknown component type: %s",
					$key,
				),
				componentKey: $key,
				previous: $exception,
			);
		}
	}
}
