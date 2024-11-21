<?php declare(strict_types=1);

namespace Torr\Storyblok\Webhook\Action;

enum WebhookAction
{
	// Asset
	case AssetCreated;
	case AssetDeleted;
	case AssetReplaced;
	case AssetRestored;

	// Datasource
	case DatasourceEntryUpdated;

	// Pipelines
	case PipelineDeployed;

	// Releases
	case ReleaseMerged;

	// Story
	case StoryDeleted;
	case StoryMoved;
	case StoryPublished;
	case StoryUnpublished;

	// User
	case UserAdded;
	case UserRolesUpdated;
	case UserRemoved;

	// Workflow
	case WorkflowStageChanged;
}
