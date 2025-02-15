3.17.0
======

* (feature) Support `description` in components.
* (improvement) Improve diff header description.
* (bug) Properly HTML-encode the preview template of components.


3.16.1
======

* (bug) Fix invalid directory name.


3.16.0
======

* (feature) Add `AssetProxyUrlGenerator` to rewrite asset URLs.
* (feature) Sign asset proxy URLs for more secure proxying.



3.15.0
======

* (feature) Add integration for app validation from the hosting bundle.
* (improvement) Bump dependencies.
* (feature) Integrate Symfony webhooks and add global `storyblok` webhook.
* (feature) Parse all supported types of webhooks and dispatch them as events.
* (feature) Add automatic asset proxy.
* (feature) Add ability to clear asset storage via CLI via `storyblok:assets:clear-proxy-storage`.
* (improvement) Add asset proxy stats to debug command.
* (feature) Automatically integrate into Storyblok webhooks to clear the image proxy storage.


3.14.3
======

* (improvement) Allow `21torr/hosting` v4.


3.14.2
======

* (improvement) Widen support for tags in TipTaps HTML to rich text transformer


3.14.1
======

* (bug) Don't crash hard when RichText Links don't contain optional properties.


3.14.0
======

* (feature) Add `ManagementApi::exportTranslationsXmlFile()` and `::importTranslationsXmlFile()`.


3.13.1
======

* (improvement) Make `StoryblokIdSlugMapper` mock-able.


3.13.0
======

* (improvement) Detect space id / content token mismatch and automatically abort all further requests.
* (feature) Add `storyblok:debug` command.
* (deprecation) Deprecate `storyblok:components:overview` command, use `storyblok:debug` instead.


3.12.1
======

* (improvement) Allow `21torr/hosting` v3.
* (improvement) Require Symfony 7.
* (improvement) Remove useless type parameter in `AbstractComponent`.
* (improvement) Improve type definitions.
* (internal) Update CI.


3.12.0
======

* (feature) Add support for rendering a `StoryChoice`'s entry appearance as Link or Card (argument: `$displayAsCard`).
* (feature) Add support for using modal / advanced search when selecting a `StoryChoice` (argument: `allowAdvancedSearch`) instead of a dropdown.


3.11.1
======

* (improvement) Ignore even more key when diffing.


3.11.0
======

* (feature) Add fetching links in `ContentApi`.
* (improvement) Use in `StoryblokIdSlugMapper` the links data from Storyblok instead of stories.


3.10.2
======

* (improvement) Allow Symfony 7.
* (improvement) Require PHP 8.3+.


3.10.1
======

* (improvement) Add `StoryblokBackendUrlGenerator::generateStoryEditUrlById()`.
* (improvement) Simplify diff generation.
* (improvement) Don't sync structure to Storyblok if not in prod.
* (improvement) Add new RichTextStyling option `RichTextStyling::UnsetFormatting`.
* (improvement) Add support for transforming HardBreak, CodeBlock, HorizontalRule and Emoji in `RichTextTransformer`.


3.10.0
======

* (feature) Add option `automaticallyTransformNonRichTextContent` to `RichTextField` to allow string as data from Storyblok and transform it to rich text data.


3.9.3
=====

* (bug) Use configurable `locale_level` to get the correct locale in `StoryMetaData::getAlternateLanguages()`.


3.9.2
=====

* (improvement) Also support older versions of `sebastian/diff`.


3.9.1
=====

* (improvement) Make types in `StoryLinkData` more strict.
* (improvement) Transform empty links in `LinkField` directly to `null`.
* (improvement) Pass `fullData` in `StoryLinkData`.


3.9.0
=====

* (feature) Show diff before syncing component definitions.
* (feature) Only sync components that actually have a change.


3.8.1
=====

* (bug) Fix sync of preview fields - Storyblok changed the way they are defined.


3.8.0
=====

* (internal) Add generic `ManagementApi::sendRequest()` to unify call structures.
* (internal) Reuse existing folder API calls in management API to not duplicate requests anymore.
* (feature) Add `ManagementApi::syncDatasourceEntries()`.
* (improvement) Require PHP 8.2+.


3.7.1
=====

* (bug) Fix invalid service excludes.


3.7.0
=====

* (feature) Add `HtmlToRichTextTransformer` to transform HTML to rich text.


3.6.0
=====

* (feature) Add option to exclude/include certain fields into the translation export.


3.5.1
=====

* (bug) Add missing validation and transformation for `AssetField` if multiple assets are allowed (allowMultiple = true).


3.5.0
=====

* (feature) Add configurable `locale_level` to better support different Storyblok directory layouts.


3.4.0
=====

* (feature) Add support for fetching `DatasourceEntry`s via `ContentApi`.


3.3.0
=====

* (feature) Extract parsing of `_editable` data into `PreviewDataParser`.
* (internal) Expose `_editable` data via `StoryMetaData::getPreviewData()`.
* (feature) Add `ComponentPreviewData` helper to easily render component meta and preview data.
* (improvement) Add support for setting minimum and maximum count of selected `ChoiceField` options.
* (bug) Add missing `symfony/lock` dependency.
* (improvement) Sort components alphabetically when syncing/validating.


3.2.2
=====

* (improvement) Add helper `ReleaseVersion::createFromPreviewFlag()`.
* (feature) Add `ComponentDataVisitorInterface` to also be able to visit components.


3.2.1
=====

*   (bug) Fix wrong namespace import of `ValidationFailedException` being used.


3.2.0
=====

*   (feature) Add support for `TableField`.


3.1.0
=====

* (feature) Add new command `storyblok:definitions:validate` to validate whether the components can be normalized.


3.0.3
=====

* (bug) Normalize enums in `tags` parameter in `ComponentManager::getComponentKeysForTags()`.
* (improvement) Properly log message about invalid component keys.


3.0.2
=====

* (improvement) Revert to previous rate limit wait time.


3.0.1
=====

* (improvement) Increase retry wait time for management API rate limiting.


3.0.0
=====

* (improvement) Ignore unknown bloks in `BloksField`.
* (feature) Add `ComponentFilter` for fields to use for simpler component filtering.
* (bc) Remove `ComponentsWithTags`, as it is replaced with `ComponentFilter`.
* (bc) Remove ability to filter by component groups.
* (improvement) Add internal `LocaleHelper` to unify locale detection.
* (feature) Add `StoryMetaData::getTranslatedDocumentsMapping()` to fetch the required data to map hreflangs.
* (deprecation) Deprecate `AbstractField::enablePreview()` in favor of `AbstractField::useAsAdminDisplayName()`.
* (improvement) Improve error reporting of choices values.
* (improvement) Use retryable HTTP clients to avoid rate limit issues. 


3.0.0-beta.5
============

* (bug) Add missing type in assert.


3.0.0-beta.4
============

* (improvement) Ignore unknown components.
* (improvement) Ignore never saved stories.


3.0.0-beta.3
============

* (feature) Add generic `RichTextTransformer`.
* (bug) Add `LinkMarksRichTextTransformer` and replace custom implementation, to cover more cases.


3.0.0-beta.2
============

* (improvement) Add a service that can bulk-transform id/uuids to full slugs.
* (bc) Only pass the `id` in `StoryLinkData` and `RichTextStoryLinkData` to improve performance of fetching Storyblok data.


3.0.0-beta.1
============

* (improvement) Allow returning enums in `AbstractComponent::getTags()`.
* (bug) Resolve inline `*LinkData` from within a `RichTextField` to their correct destination.


3.0.0-beta.0
============

* (improvement) Show space info when syncing definitions.
* (feature) Add dry-run mode for component sync.
* (bc) Enable dry run mode by default.
* (bug) Fix `full_slug` link field, by fetching it fresh from the API. 
* (feature) Add possibility to load info about the current space. 

 
2.6.2
=====

* (improvement) Add new `RichTextStyling` options.


2.6.1
=====

* (improvement) Also pass `uid` in `ComponentData`.


2.6.0
=====

* (bug) Fix invalid type definition.
* (feature) Transform data of embedded blocks in RTE fields.


2.5.2
=====

* (improvement) Allow value-objects to be returned from `CompositeField::transformData()`.


2.5.1
=====

* (bug) Fix empty check in `RichTextField`.


2.5.0
=====

* (feature) Add console command `storyblok:components:overview`.


2.4.2
=====

* (bug) Fix data validation in `StaticChoices`.


2.4.1
=====

* (bug) Fix calculation of total number of pages of Storyblok API result.


2.4.0
=====

* (feature) Add automatic pagination support in the content API.
* (feature) Add automatic retry for the storyblok API.
* (bug) Fix validation for empty `BloksField`s.


2.3.0
=====

* (feature) Extract image dimensions from Storyblok URLs into `AssetData` and `AssetLinkData`.


2.2.0
=====

* (feature) Add `FolderData` + `ManagementApi::fetchFoldersInPath()`.


2.1.1
=====

* (improvement) Use `StoryInterface` instead of `Story` as parameter type in methods.


2.1.0
=====

* (improvement) Always sort Stories by their internal `position` field.
* (feature) Expose internal `position` via `StoryMetaData::getPosition()`.


2.0.1
=====

* (improvement) Improve exception message for better tracing/debugging when hydration of a `Story` fails due to invalid data.


2.0.0
=====

* (improvement) Add `StoryInterface`. 
* (bc) Use `fullSlug` in `StoryLinkData`. 
* (bc) Add better support for multiple story references via `StoryReferenceList`.


1.5.0
=====

* (feature) Add management API method, to fetch the section title maps.


1.4.6
=====

* (bug) Send correct key in order to set RegExp validation for Fields.


1.4.5
=====

* (improvement) Try to use `cv` in the API client and remove the local rate limiter.


1.4.4
=====

* (improvement) Add full slug as label to top-level components' validation path.


1.4.3
=====

* (improvement) Revert adjustments from 1.4.2 to keep the codebase simpler.


1.4.2
=====

* (improvement) Pass the component definition in `ComponentData`.


1.4.1
=====

* (improvement) Add getter for story slug segments.


1.4.0
=====

* (bug) Fix RateLimiter configuration for Storyblok's Content API to hopefully not exceed their rate limit.
* (improvement) Prevent automatic API redirect by sorting the query parameters pre-emptively.
* (feature) Add support for fetching different `ReleaseVerion`s in `ContentApi::fetchStories()` and `::fetchAllStories()`.
* (bug) Fix handling of `BooleanField` with `allowMissingData` set to `true`.


1.3.0
=====

* (feature) Add support for fetching a Story directly via their Uuid from the Storyblok Content API. 
* (feature) Add `StoryReferenceData`. 
* (bc) The `StoryChoices` no longer return the Uuid(s) of the referenced Stories. Instead, it returns the `StoryReferenceData` object(s).
* (feature) Add support for specifying a data mode key for the `StoryChoices` instance, which will be passed down to the corresponding `*StoryNormalizer`, which can conditionally return different data based on the mode key.


1.2.1
=====

* (bug) Fix invalid handling of `AbstractGroupingElement` fields.
* (bug) Don't crash when `CompositeField` field data is not present (for `allowMissingData` cases).


1.2.0
=====

* (bug) Fix invalid handling of nested fields.
* (feature) Add `CompositeField` to allow logical grouping of multiple fields.


1.1.1
=====

* (bug) Fix invalid handling of multi-select `ChoiceField`.



1.1.0
=====

* (feature) Add preview info for `ComponentData`.



1.0.0
=====

*   (feature) Initial Release
