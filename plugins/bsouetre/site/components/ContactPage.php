<?php

namespace BSouetre\Site\Components;

use BSouetre\Site\Models\Setting;
use Cms\Classes\ComponentBase;

/**
 * Class ContactPage
 * @package BSouetre\Site\Components
 */
class ContactPage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Composant Page Contact',
            'description' => 'Gestion de la page Contact'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

	public function onRun()
	{
		$this->page[ 'contact_email' ] = Setting::get( 'email' );
		$this->page[ 'nav' ] = [
			'home' => [ 'title' => 'Accueil', 'url' => $this->controller->pageUrl( 'home' ) ],
			'archives' => [ 'title' => 'Archives', 'url' => $this->controller->pageUrl( 'archives' ) ],
			'about' => [ 'title' => 'À Propos', 'url' => $this->controller->pageUrl( 'about' ) ],
			'contact' => [ 'title' => 'Contact', 'url' => $this->controller->pageUrl( 'contact' ) ]
		];
	}
}
