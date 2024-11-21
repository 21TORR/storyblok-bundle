<?php declare(strict_types=1);

namespace Torr\Storyblok\Assets\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Torr\Storyblok\Assets\Proxy\AssetProxy;

/**
 * @final
 */
class AssetProxyController extends AbstractController
{
	public function proxyAsset (
		AssetProxy $assetProxy,
		Request $request,
		string $width,
		string $height,
		string $assetId,
		string $filename,
	) : Response
	{
		$path = \sprintf("%sx%s/%s/%s", $width, $height, $assetId, $filename);
		$filePath = $assetProxy->getFilePath($path);

		if (null === $filePath)
		{
			throw $this->createNotFoundException("File not found");
		}

		return $this->file(
			$filePath,
			disposition: $request->query->has("download")
				? ResponseHeaderBag::DISPOSITION_ATTACHMENT
				: ResponseHeaderBag::DISPOSITION_INLINE,
		);
	}
}
