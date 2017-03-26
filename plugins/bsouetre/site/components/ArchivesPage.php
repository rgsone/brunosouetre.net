<?php

namespace BSouetre\Site\Components;

use Backend\Facades\BackendAuth;
use BSouetre\Site\Models\Category;
use BSouetre\Site\Models\Project;
use BSouetre\Site\Models\Tag;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use October\Rain\Database\Collection;
use October\Rain\Support\Facades\Config;

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
		$projects = Project::where( 'published', true )->orderBy( 'date', 'desc' )->get();
		$isAuthUser = BackendAuth::getUser();
		$projectsByDate = [];

		foreach ( $projects as $project )
		{
			$project->setUrl( 'project', $this->controller );

			# assign by date

			$dateHelper = Carbon::parse( $project->date, Config::get( 'app.timezone' ) );
			# check for private project
			if ( !$project->private || ( $project->private && $isAuthUser ) )
				$projectsByDate[ $dateHelper->year ][] = $project;
		}

		# inject var in page

		$this->page[ 'categories' ] = Category::all();
		$this->page[ 'tags' ] = Tag::all();
		$this->page[ 'projectsByDate' ] = $projectsByDate;
	}
}
