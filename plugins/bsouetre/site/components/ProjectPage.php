<?php

namespace BSouetre\Site\Components;

use Cms\Classes\ComponentBase;
use BSouetre\Site\Models\Project;

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

		# get project from slug if exist and is published
		try {
			/** @var Project $project */
			$project = Project::where( 'slug', $this->currentSlug )->where( 'published', true )->firstOrFail();
		} catch ( \Exception $e ) {
			$this->setStatusCode( 404 );
			return $this->controller->run( '404' );
		}

		# inject var in page
		$this->page['slug'] = $this->currentSlug;
		$this->page['project'] = $project;
	}
}
