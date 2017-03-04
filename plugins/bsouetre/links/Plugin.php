<?php

namespace BSouetre\Links;

use Backend;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package BSouetre\Links
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Links',
            'description' => 'Manage links',
            'author' => 'rgsone',
            'icon' => 'icon-link'
        ];
    }

    public function register()
    {

    }

    public function boot()
    {

    }

    public function registerPermissions()
    {
        return [
            'bsouetre.links.access_links' => [
                'tab' => 'Links',
                'label' => 'Gestion des liens'
            ]
        ];
    }

    public function registerNavigation()
    {
        return [
            'links' => [
                'label' => 'Liens',
                'url' => Backend::url( 'bsouetre/links/links' ),
                'icon' => 'icon-link',
                'permissions' => [ 'bsouetre.links.*' ],
                'order' => 500,
				'sideMenu' => [
					'links' => [
						'label' => 'Liens',
						'icon' => 'icon-child',
						'url' => Backend::url( 'bsouetre/links/links' ),
						'permissions' => [ 'pabsouetre.links.access_links' ]
					]
				]
			]
		];
    }
}
