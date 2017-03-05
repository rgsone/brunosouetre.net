<?php

namespace BSouetre\Site;

use Backend\Facades\Backend;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package BSouetre\Site
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Brun Souetre Portfolio',
            'description' => 'Gestion du portfolio',
            'author' => 'rgsone',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerPermissions()
    {
        return [
			'bsouetre.site.access_links' => [
				'tab' => 'Site',
				'label' => 'Gestion des liens'
			],
			'bsouetre.site.access_projects' => [
				'tab' => 'Site',
				'label' => 'Gestion des projets'
			]
        ];
    }

    public function registerNavigation()
    {
        return [
            'site' => [

                'label' => 'Site',
                'url' => Backend::url( 'bsouetre/site/links' ),
                'icon' => 'icon-leaf',
                'permissions' => [ 'bsouetre.site.*' ],
                'order' => 500,

				'sideMenu' => [
					'links' => [
						'label' => 'Liens',
						'icon' => 'icon-link',
						'url' => Backend::url( 'bsouetre/site/links' ),
						'permissions' => [ 'bsouetre.site.access_links' ]
					]
				]

            ]
        ];
    }

}
