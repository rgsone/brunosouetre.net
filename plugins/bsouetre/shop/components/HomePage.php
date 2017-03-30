<?php

namespace BSouetre\Shop\Components;

use BSouetre\Shop\Models\Item;
use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;

/**
 * Class HomePage
 * @package BSouetre\Shop\Components
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
		/** @var Collection $items */
		$items =  Item::where( 'published', true )->orderBy( 'created_at', 'desc' )->get();

		# inject vars

		$this->page[ 'items' ] = $items;
	}
}
