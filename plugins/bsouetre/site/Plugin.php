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
            'name' => 'BrunoSouetreSite',
            'description' => 'Gestion du site/portfolio',
            'author' => 'rgsone',
            'icon' => 'icon-desktop'
        ];
    }

    public function registerPermissions()
    {
        return [
			'bsouetre.site.access_links' => [
				'tab' => 'Site',
				'label' => 'Gestion des liens'
			],
			'bsouetre.site.access_about' => [
				'tab' => 'Site',
				'label' => 'Gestion de la page à propos'
			],
			'bsouetre.site.access_projects' => [
				'tab' => 'Site',
				'label' => 'Gestion des projets'
			],
			'bsouetre.site.access_categories' => [
				'tab' => 'Site',
				'label' => 'Gestion des categories'
			]
        ];
    }

    public function registerNavigation()
    {
        return [
            'site' => [

                'label' => 'Site',
                'url' => Backend::url( 'bsouetre/site/links' ),
                'icon' => 'icon-desktop',
                'permissions' => [ 'bsouetre.site.*' ],
                'order' => 500,

				'sideMenu' => [

					'categories' => [
						'label' => 'Catégories',
						'icon' => 'icon-tags',
						'url' => Backend::url( 'bsouetre/site/categories' ),
						'permissions' => [ 'bsouetre.site.access_catagories' ]
					],

					'links' => [
						'label' => 'Liens',
						'icon' => 'icon-link',
						'url' => Backend::url( 'bsouetre/site/links' ),
						'permissions' => [ 'bsouetre.site.access_links' ]
					],

					'about' => [
						'label' => 'À Propos',
						'icon' => 'icon-info-circle',
						'url' => Backend::url( 'bsouetre/site/about' ),
						'permissions' => [ 'bsouetre.site.access_about' ]
					]

				]

            ]
        ];
    }

}
