<?php

namespace Rgsone\ViteAssetsResolver;

use Illuminate\Foundation\AliasLoader;
use Rgsone\ViteAssetsResolver\Classes\ViteAssetsResolverFacade;
use Rgsone\ViteAssetsResolver\Classes\ViteAssetsResolverServiceProvider;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package Rgsone\ViteAssetsResolver
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Vite Assets Resolver',
            'description' => 'Generate script and stylesheet tag for Vite frontend dev',
            'author' => 'rgsone',
            'icon' => 'icon-leaf'
        ];
    }

	public function boot()
	{
		$this->app->register(ViteAssetsResolverServiceProvider::class);
		AliasLoader::getInstance()->alias('Vite', ViteAssetsResolverFacade::class);
	}

	/**
	 * Register twig function
	 * @return array
	 */
	public function registerMarkupTags()
	{
		return [
			'functions' => [
				'vite_assets_resolver' => [$this, 'resolveAssets'],
			],
		];
	}

	/**
	 * @param string $clientUrl
	 * @param string $scriptEntryUrl
	 * @param string $entryFilePath
	 * @param array $dependencies
	 * @return string
	 */
	public function resolveAssets(string $clientUrl = '', string $scriptEntryUrl = '', string $entryFilePath = '', bool $forceProd = false, array $dependencies = []):string
	{
		return \Vite::resolveAsset($clientUrl, $scriptEntryUrl, $entryFilePath, $forceProd, $dependencies);
	}
}
