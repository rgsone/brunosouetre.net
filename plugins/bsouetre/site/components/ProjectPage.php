<?php

namespace BSouetre\Site\Components;

use Backend\Facades\BackendAuth;
use BSouetre\Site\Models\Project;
use Cms\Classes\ComponentBase;
use October\Rain\Support\Facades\Config;

/**
 * Class ProjectPage
 * @package BSouetre\Site\Components
 */
class ProjectPage extends ComponentBase
{
	protected $currentSlug = '';

    public function componentDetails()
    {
        return [
            'name' => 'Composant Page Projet',
            'description' => 'Gestion de la page Projet'
        ];
    }

    public function defineProperties()
    {
        return [
        	'slug' => [
				'title' => 'URL slug du projet',
				'description' => 'URL slug d\'accés au projet',
				'default' => '{{ :name }}',
				'type' => 'string'
			]
		];
    }

    public function onRun()
	{
		$this->currentSlug = $this->property( 'slug' );

		# get project from slug if exist

		try {
			/** @var Project $project */
			$project = Project::where( 'slug', $this->currentSlug )->firstOrFail();
		} catch ( \Exception $e ) {
			$this->setStatusCode( 404 );
			return $this->controller->run( '404' );
		}

		# check if private and if an user is auth

		if ( $project->private && BackendAuth::getUser() == null )
		{
			$this->setStatusCode( 403 );
			return $this->controller->run( 'error' );
		}

		# inject vars

		$this->page[ 'project' ] = $project;

		$this->page[ 'date_format' ] = Config::get( 'bsouetre.site::date_format.' . $project->date_format, 'm/Y' );

		$this->page[ 'nav' ] = [
			'home' => [ 'url' => $this->controller->pageUrl( 'home' ) ],
			'archives' => [ 'url' => $this->controller->pageUrl( 'archives' ) ],
			'about' => [ 'url' => $this->controller->pageUrl( 'about' ) ],
			'contact' => [ 'url' => $this->controller->pageUrl( 'contact' ) ]
		];
	}
}
