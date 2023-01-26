<?php

namespace Rgsone\ViteAssetsResolver\Classes;

use Cms\Classes\Controller;
use Cms\Classes\Theme;
use Illuminate\Support\ServiceProvider;
use October\Rain\Support\Facades\Config;

/**
 * Class ViteAssetsResolverServiceProvider
 * @package Rgsone\ViteAssetsResolver\Classes
 */
class ViteAssetsResolverServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton(ViteAssetsResolver::class, function ($app) {
			$isDev = Config::get('app.debug', false);
			$themePath = Theme::getActiveTheme()->getPath();
			$controller = Controller::getController() ?: new Controller();
			$assetsBaseUrl = $controller->themeUrl('assets');
			return new ViteAssetsResolver(
				$isDev, "${themePath}/assets/manifest.json", $assetsBaseUrl
			);
		});
	}
}
