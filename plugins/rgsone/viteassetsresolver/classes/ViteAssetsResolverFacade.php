<?php

namespace Rgsone\ViteAssetsResolver\Classes;

use October\Rain\Support\Facade;
use Rgsone\ViteAssetsResolver\Classes\ViteAssetsResolver;

/**
 * Class ViteAssetsResolverFacade
 * @package Rgsone\ViteAssetsResolver\Classes\Facades
 */
class ViteAssetsResolverFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return ViteAssetsResolver::class;
	}
}
