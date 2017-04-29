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

	public function registerComponents()
	{
		return [
			'BSouetre\Site\Components\HomePage' => 'siteHomePage',
			'BSouetre\Site\Components\ArchivesPage' => 'siteArchivesPage',
			'BSouetre\Site\Components\ProjectPage' => 'siteProjectPage',
			'BSouetre\Site\Components\AboutPage' => 'siteAboutPage',
			'BSouetre\Site\Components\ContactPage' => 'siteContactPage'
		];
	}

    public function registerPermissions()
    {
        return [
			'bsouetre.site.access_links' => [
				'tab' => 'Site',
				'label' => 'Gestion des liens'
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
                'url' => Backend::url( 'bsouetre/site/projects' ),
                'icon' => 'icon-desktop',
                'permissions' => [ 'bsouetre.site.*' ],
                'order' => 11,

				'sideMenu' => [

					'categories' => [
						'label' => 'Catégories',
						'icon' => 'icon-tag',
						'url' => Backend::url( 'bsouetre/site/categories' ),
						'permissions' => [ 'bsouetre.site.access_categories' ]
					],

					'tags' => [
						'label' => 'Tags',
						'icon' => 'icon-tags',
						'url' => Backend::url( 'bsouetre/site/tags' ),
						'permissions' => [ 'bsouetre.site.access_tags' ]
					],

					'projects' => [
						'label' => 'Projets',
						'icon' => 'icon-archive',
						'url' => Backend::url( 'bsouetre/site/projects' ),
						'permissions' => [ 'bsouetre.site.access_projects' ]
					],

					'links' => [
						'label' => 'Liens',
						'icon' => 'icon-link',
						'url' => Backend::url( 'bsouetre/site/links' ),
						'permissions' => [ 'bsouetre.site.access_links' ]
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
