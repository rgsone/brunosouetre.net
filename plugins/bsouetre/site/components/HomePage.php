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
		$this->page[ 'nav' ] = [
			'home' => [ 'title' => 'Accueil', 'url' => $this->controller->pageUrl( 'home' ) ],
			'archives' => [ 'title' => 'Archives', 'url' => $this->controller->pageUrl( 'archives' ) ],
			'about' => [ 'title' => 'À Propos', 'url' => $this->controller->pageUrl( 'about' ) ],
			'contact' => [ 'title' => 'Contact', 'url' => $this->controller->pageUrl( 'contact' ) ]
		];
	}
}
