<?php

namespace BSouetre\Galleries\Components;

use Cms\Classes\ComponentBase;

/**
 * Class GalleryPage
 * @package BSouetre\Galleries\Components
 */
class GalleryPage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Composant Page Galerie',
            'description' => 'Gestion de la page Galerie'
        ];
    }

	public function onRun()
	{
		$this->page[ 'gallery' ] = [];
	}
}
