<?php

namespace BSouetre\Galleries;

use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package BSouetre\Galleries
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'BrunoSouetreGalleries',
            'description' => 'Gestion des galeries',
            'author' => 'rgsone',
            'icon' => 'icon-picture-o'
        ];
    }

    public function registerComponents()
    {
    	return [
			'BSouetre\Galleries\Components\HomePage' => 'galleriesHomePage',
			'BSouetre\Galleries\Components\GalleryPage' => 'galleriesGalleryPage'
        ];
    }
}
