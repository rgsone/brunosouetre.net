<?php

namespace BSouetre\Galleries\Components;

use Cms\Classes\ComponentBase;

/**
 * Class HomePage
 * @package BSouetre\Galleries\Components
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

	public function onRun()
	{
		$this->page[ 'galleries' ] = [];
	}
}
