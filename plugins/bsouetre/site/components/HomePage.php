<?php

namespace BSouetre\Site\Components;

use Backend\Facades\BackendAuth;
use BSouetre\Site\Models\Project;
use BSouetre\Site\Models\Setting;
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
		/** @var Collection $projects */
		$projects =  Project::where( 'published', true )
			->where( 'featured', true )
			->orderBy( 'date', 'desc' )
			->get();

		foreach ( $projects as $project )
			$project->setUrl( 'project', $this->controller );

		# inject vars

		$this->page[ 'selected_projects' ] = $projects;
		$this->page[ 'is_auth_user' ] = BackendAuth::getUser();
		$this->page[ 'highlighted' ] = [
			'activated' => (boolean)Setting::get( 'highlighted_item_activated', false ),
			'img' => Setting::instance()->highlighted_item_img->getPath(),
			'desc' => Setting::get( 'highlighted_item_desc' ),
			'url' => Setting::get( 'highlighted_item_url' )
		];
	}
}
