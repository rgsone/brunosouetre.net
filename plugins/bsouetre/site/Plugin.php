<?php

namespace BSouetre\Site;

use Backend\Facades\Backend;
use Illuminate\Support\Facades\DB;
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
			'bsouetre.site.access_settings' => [
				'tab' => 'Site',
				'label' => 'Gestion des paramétres du site'
			],
			'bsouetre.site.access_projects' => [
				'tab' => 'Site',
				'label' => 'Gestion des projets'
			],
			'bsouetre.site.access_categories' => [
				'tab' => 'Site',
				'label' => 'Gestion des categories'
			],
			'bsouetre.site.access_tags' => [
				'tab' => 'Site',
				'label' => 'Gestion des tags'
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
						'icon' => 'icon-tag',
						'url' => Backend::url( 'bsouetre/site/categories' ),
						'permissions' => [ 'bsouetre.site.access_catagories' ]
					],

					'tags' => [
						'label' => 'Tags',
						'icon' => 'icon-tags',
						'url' => Backend::url( 'bsouetre/site/tags' ),
						'permissions' => [ 'bsouetre.site.access_tags' ]
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
					],

					'settings' => [
						'label' => 'Paramétres du site',
						'icon' => 'icon-cog',
						'url' => Backend::url( 'bsouetre/site/settings' ),
						'permissions' => [ 'bsouetre.site.access_settings' ]
					]

				]

            ]
        ];
    }

    public function boot()
	{
		# set foreign keys management in sqlite
		if ( config( 'database.default' ) == 'sqlite' )
			DB::statement( DB::raw( 'PRAGMA foreign_keys=1' ) );
	}

}
