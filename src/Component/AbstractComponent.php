<?php declare(strict_types=1);

namespace Torr\Storyblok\Component;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Torr\Storyblok\Component\Config\ComponentType;
use Torr\Storyblok\Component\Data\ComponentData;
use Torr\Storyblok\Component\Definition\ComponentDefinition;
use Torr\Storyblok\Context\ComponentContext;
use Torr\Storyblok\Exception\InvalidComponentConfigurationException;
use Torr\Storyblok\Exception\Story\InvalidDataException;
use Torr\Storyblok\Field\Collection\FieldCollection;
use Torr\Storyblok\Field\Data\Helper\InlinedTransformedData;
use Torr\Storyblok\Field\FieldDefinitionInterface;
use Torr\Storyblok\Management\ManagementApiData;
use Torr\Storyblok\Story\Story;
use Torr\Storyblok\Visitor\ComponentDataVisitorInterface;
use Torr\Storyblok\Visitor\DataVisitorInterface;

/**
 * Base class for all components registered in the system
 */
abstract class AbstractComponent
{
	private ?FieldCollection $fields = null;

	/**
	 * Returns the unique key for this component
	 */
	abstract public static function getKey () : string;

	/**
	 * Configures the component
	 */
	protected function configureComponent () : ComponentDefinition
	{
		return new ComponentDefinition();
	}

	/**
	 * Configures the fields in this component
	 *
	 * @return array<string, FieldDefinitionInterface>
	 */
	abstract protected function configureFields () : array;

	/**
	 * Returns the type of this component
	 */
	abstract protected function getComponentType () : ComponentType;

	/**
	 * Returns the human-readable name of this component
	 */
	abstract public function getDisplayName () : string;

	/**
	 * Returns the component group display name
	 */
	public function getComponentGroup () : string|\BackedEnum|null
	{
		return null;
	}

	/**
	 * Returns the tags of this component
	 *
	 * @return list<string|\BackedEnum>
	 */
	public function getTags () : array
	{
		return [];
	}

	/**
	 * Returns the class of story to create for this component.
	 * If null is returned here, you can't create a story for that component
	 *
	 * @return class-string<Story>|null
	 */
	public function getStoryClass () : ?string
	{
		return null;
	}

	/**
	 * Receives the Storyblok data for the given field and transforms it for better usage
	 */
	public function transformData (
		array $data,
		ComponentContext $dataContext,
		?DataVisitorInterface $dataVisitor = null,
	) : ComponentData
	{
		$transformedData = [];

		foreach ($this->getFields()->getRootFields() as $fieldName => $field)
		{
			$transformedFieldData = $field->transformData(
				$data[$fieldName] ?? null,
				$dataContext,
				$data,
				$dataVisitor,
			);

			if ($transformedFieldData instanceof InlinedTransformedData)
			{
				$transformedData = [
					...$transformedData,
					...$transformedFieldData->data,
				];
			}
			else
			{
				$transformedData[$fieldName] = $transformedFieldData;
			}
		}

		$componentData = new ComponentData(
			$data["_uid"],
			static::getKey(),
			$transformedData,
			previewData: $data["_editable"] ?? null,
		);

		if ($dataVisitor instanceof ComponentDataVisitorInterface)
		{
			$dataVisitor->onDataVisit($this, $componentData);
		}

		return $componentData;
	}

	/**
	 * Transforms the data of a single field
	 */
	public function transformField (
		array $data,
		string $fieldName,
		ComponentContext $dataContext,
		?DataVisitorInterface $dataVisitor = null,
	) : mixed
	{
		$field = $this->getFields()->getField($fieldName);

		return $field->transformData(
			$data[$fieldName] ?? null,
			$dataContext,
			$data,
			$dataVisitor,
		);
	}

	/**
	 * @throws InvalidDataException
	 */
	public function validateData (
		ComponentContext $context,
		mixed $data,
		array $contentPath = [],
		?string $label = null,
	) : void
	{
		$contentPath = [
			...$contentPath,
			\sprintf("Component(%s, '%s')", static::getKey(), $label ?? "n/a"),
		];

		// validate base data
		$context->validator->ensureDataIsValid(
			$contentPath,
			$this,
			$data,
			[
				new NotNull(),
				new Type("array"),
				new Collection(
					fields: [
						"_uid" => [
							new NotNull(),
							new Type("string"),
						],
						"component" => [
							new NotNull(),
							new Type("string"),
						],
					],
					allowExtraFields: true,
					allowMissingFields: false,
				),
			],
		);

		\assert(\is_array($data));

		foreach ($this->getFields()->getRootFields() as $name => $field)
		{
			$fieldData = $data[$name] ?? null;

			$field->validateData(
				$context,
				[
					...$contentPath,
					\sprintf("Field(%s)", $name),
				],
				$fieldData,
				$data,
			);
		}
	}

	final protected function getFields () : FieldCollection
	{
		return $this->fields ??= new FieldCollection($this->configureFields());
	}

	/**
	 * Normalizes the fields for usage in the management API
	 *
	 * @param array<string, FieldDefinitionInterface> $fields
	 */
	private function normalizeFields (
		array $fields,
	) : array
	{
		if (empty($fields))
		{
			throw new InvalidComponentConfigurationException(\sprintf(
				"Invalid component '%s': can't have a component without fields",
				static::class,
			));
		}

		$managementDataApi = new ManagementApiData();

		foreach ($fields as $key => $field)
		{
			if (ComponentHelper::isReservedKey($key))
			{
				throw new InvalidComponentConfigurationException(\sprintf(
					"Invalid component configuration '%s': can't use '%s' as field key, as that is a reserved key.",
					static::class,
					$key,
				));
			}

			$field->registerManagementApiData($key, $managementDataApi);
		}

		return $managementDataApi->getFullConfig();
	}

	/**
	 * Transforms the data for the component
	 *
	 * @internal
	 */
	final public function toManagementApiData () : array
	{
		if (ComponentHelper::isReservedKey(static::getKey()))
		{
			throw new InvalidComponentConfigurationException(\sprintf(
				"Invalid component configuration '%s': can't use '%s' as component key, as that is a reserved key.",
				static::class,
				static::getKey(),
			));
		}

		$definition = $this->configureComponent();
		$previewField = null;

		foreach ($this->getFields()->getRootFields() as $key => $field)
		{
			if ($field->isStoryblokPreviewField())
			{
				$previewField = $key;
				break;
			}
		}

		return [
			"name" => static::getKey(),
			"display_name" => $this->getDisplayName(),
			"schema" => $this->normalizeFields($this->getFields()->getRootFields()),
			"image" => $definition->previewScreenshotUrl,
			"preview_tmpl" => null !== $definition->previewTemplate
				? htmlspecialchars(
					$definition->previewTemplate,
					\ENT_NOQUOTES | \ENT_SUBSTITUTE | \ENT_HTML5,
				)
				: null,
			"preview_field" => $previewField,
			"color" => $definition->iconBackgroundColor,
			"icon" => $definition->icon?->value,
			"description" => $definition->description,
			...$this->getComponentType()->toManagementApiData(),
		];
	}
}
