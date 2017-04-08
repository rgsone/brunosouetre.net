<?php

namespace BSouetre\Galleries\Components;

use BSouetre\Galleries\Classes\Router;
use Cms\Classes\ComponentBase;
use October\Rain\Support\Facades\Config;

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

	public function defineProperties()
	{
		return [
			'slug' => [
				'title' => 'URL slug de la galerie',
				'description' => 'URL slug d\'accés à la galerie',
				'default' => '{{ :name }}',
				'type' => 'string'
			]
		];
	}

	public function onRun()
	{
		$router = new Router( Config::get( 'bsouetre.galleries::path' ) );
		$gallery = $router->forUrl( $this->property( 'slug' ) );

		if ( null === $gallery || $gallery->published === false )
		{
			$this->setStatusCode( 404 );
			return $this->controller->run( '404' );
		}

		$gallery->setCacheRefresh( Config::get( 'app.debug', false ) );
		$gallery->setCacheTtl( Config::get( 'bsouetre.galleries::cacheTTL.images', 1 ) );
		$gallery->getImages();

		$this->page[ 'gallery' ] = $gallery;
	}
}
