<?php

namespace BSouetre\Site\Components;

use Cms\Classes\ComponentBase;

/**
 * Class HomePage
 * @package BSouetre\Site\Components
 */
class HomePage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Composant Page Accueil',
            'description' => 'Gestion de la page Accueil'
        ];
    }

    public function defineProperties()
    {
        return [];
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
