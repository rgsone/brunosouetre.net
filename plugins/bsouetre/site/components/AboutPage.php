<?php

namespace BSouetre\Site\Components;

use BSouetre\Site\Models\About;
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
		$this->page[ 'content' ] = About::get( 'content', '' );
		$this->page[ 'nav' ] = [
			'home' => [ 'title' => 'Accueil', 'url' => $this->controller->pageUrl( 'home' ) ],
			'archives' => [ 'title' => 'Archives', 'url' => $this->controller->pageUrl( 'archives' ) ],
			'about' => [ 'title' => 'À Propos', 'url' => $this->controller->pageUrl( 'about' ) ],
			'contact' => [ 'title' => 'Contact', 'url' => $this->controller->pageUrl( 'contact' ) ]
		];
	}
}
