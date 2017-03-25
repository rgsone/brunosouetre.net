<?php

namespace BSouetre\Site\Components;

use BSouetre\Site\Models\Link;
use BSouetre\Site\Models\Setting;
use Cms\Classes\ComponentBase;

/**
 * Class AboutPage
 * @package BSouetre\Site\Components
 */
class AboutPage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Composant Page À Propos',
            'description' => 'Gestion de la page À Propos'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

	public function onRun()
	{
		$this->page[ 'content' ] = Setting::get( 'about_content' );
		$this->page[ 'links' ] = Link::orderBy( 'name', 'asc' )->get();
		$this->page[ 'nav' ] = [
			'home' => [ 'url' => $this->controller->pageUrl( 'home' ) ],
			'archives' => [ 'url' => $this->controller->pageUrl( 'archives' ) ],
			'about' => [ 'url' => $this->controller->pageUrl( 'about' ) ],
			'contact' => [ 'url' => $this->controller->pageUrl( 'contact' ) ]
		];
	}
}
