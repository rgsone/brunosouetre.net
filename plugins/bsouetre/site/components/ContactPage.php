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
		$this->page[ 'email' ] = Setting::get( 'email' );
	}
}
