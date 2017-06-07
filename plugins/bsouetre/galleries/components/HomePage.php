<?php

namespace BSouetre\Galleries\Components;

use BSouetre\Galleries\Classes\GalleryList;
use BSouetre\Galleries\Classes\Router;
use Cms\Classes\ComponentBase;
use October\Rain\Support\Facades\Config;

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
		$router = new Router( Config::get( 'bsouetre.galleries::path' ) );
		$galleryList = new GalleryList( $router );
		$galleryList->setCacheTtl( Config::get( 'bsouetre.galleries::cacheTTL.galleries', 1 ) );
		$galleries = $galleryList->listGalleries( Config::get( 'app.debug', false ) );

		// TODO : check if $galleries == null before call filter
		// TODO : check if one or more galleries exist in template

		if ( null !== $galleries )
		{
			$galleries = $galleries->filter( function( $item ) {
				return ( $item->published == true && $item->listed == true );
			});
		}

		$this->page[ 'galleries' ] = $galleries;
	}
}
