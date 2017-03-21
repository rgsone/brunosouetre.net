<?php

namespace BSouetre\Site\Components;

use BSouetre\Site\Models\Project;
use Cms\Classes\ComponentBase;
use October\Rain\Database\Collection;

/**
 * Class ArchivesPage
 * @package BSouetre\Site\Components
 */
class ArchivesPage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Composant Page Archives',
            'description' => 'Gestion de la page Archives'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

	public function onRun()
	{
		/** @var Collection $projects */
		$projects = Project::where( 'published', true )
			->orderBy( 'date', 'desc' )
			->get();

		foreach ( $projects as $project )
		{
			//$project->url = $this->controller->pageUrl( 'project', [ 'name' => $project->slug ] );
			$project->setUrl( 'project', $this->controller );
		}

		# inject var in page
		$this->page['projects'] = $projects;
		$this->page[ 'nav' ] = [
			'home' => [ 'title' => 'Accueil', 'url' => $this->controller->pageUrl( 'home' ) ],
			'archives' => [ 'title' => 'Archives', 'url' => $this->controller->pageUrl( 'archives' ) ],
			'about' => [ 'title' => 'À Propos', 'url' => $this->controller->pageUrl( 'about' ) ],
			'contact' => [ 'title' => 'Contact', 'url' => $this->controller->pageUrl( 'contact' ) ]
		];
	}
}
