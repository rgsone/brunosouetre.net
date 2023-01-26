<?php

namespace Rgsone\ViteAssetsResolver\Classes;

use Cms\Classes\Theme;
use League\Flysystem\Exception;

/**
 * Class ViteAssetsResolver
 * @package Rgsone\ViteAssetsResolver\Classes
 */
class ViteAssetsResolver
{
	protected $isDev = false;
	protected $manifestPath = '';
	protected $assetsBaseUrl = '';

	public function __construct(bool $isDev = false, string $manifestPath = '', string $assetsBaseUrl = '')
	{
		$this->isDev = $isDev;
		$this->manifestPath = $manifestPath;
		$this->assetsBaseUrl = rtrim($assetsBaseUrl, '/');
	}

	public function resolveAsset(string $clientUrl = '', string $scriptEntryUrl = '', string $entryFilePath = '', bool $forceProd = false, array $dependencies = []):string
	{
		return $forceProd || !$this->isDev ?
			$this->resolveProd($entryFilePath) :
			$this->resolveDev($clientUrl, $scriptEntryUrl, $dependencies);
	}

	protected function resolveDev(string $clientUrl, string $scriptEntryUrl, array $dependencies):string
	{
		return <<<HTML
	<script type="module" src="$clientUrl"></script>
	<script type="module" src="$scriptEntryUrl"></script>
HTML;
	}

	protected function resolveProd(string $entryFilePath):string
	{
		$manifest = json_decode(file_get_contents($this->manifestPath), true);
		$jsFile = $manifest[$entryFilePath]['file'] ?: '';
		$cssFiles = $manifest[$entryFilePath]['css'] ?: [];
		$scriptSrc = $this->assetsBaseUrl . '/' . ltrim($jsFile, '/');
		$html = '';

		foreach ($cssFiles as $css)
		{
			$html .= "<link href=\"{$this->assetsBaseUrl}/{$css}\" rel=\"stylesheet\" media=\"screen\">\n";
		}

		//$html .= "<script src="{$scriptSrc}" defer></script>";
		$html .= "<script type=\"module\" src=\"{$scriptSrc}\" defer></script>";

		return $html;
	}
}
