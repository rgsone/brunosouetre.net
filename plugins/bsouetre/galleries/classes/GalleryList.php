<?php

namespace BSouetre\Galleries\Classes;

use Illuminate\Support\Facades\Cache;
use October\Rain\Database\Collection;

/**
 * Class GalleryList
 * @package BSouetre\Galleries\Classes
 */
class GalleryList
{
	/** @var Router */
	protected $router;
	/** @var string */
	protected $cacheKey;
	/** @var int In minutes */
	protected $cacheTtl = 1;

	/**
	 * GalleryList constructor.
	 * @param $router Router
	 */
	public function __construct( $router )
	{
		$this->router = $router;
		$this->cacheKey = crc32( 'galleries-gallerylist-map' );
	}

	/**
	 * @param bool $fresh
	 * @return null|Collection
	 */
	public function listGalleries( $fresh = false )
	{
		$dirMap = $this->router->getUrlMap();

		if ( empty( $dirMap ) ) return null;

		$cached = Cache::get( $this->cacheKey, false );

		if ( $cached && $fresh === false )
		{
			$data = @unserialize( $cached );

			if ( $data !== false )
				return new Collection( $data );
		}

		$galleries = [];

		foreach ( $dirMap as $url => $path )
			$galleries[] = new Gallery( $path, $url );

		Cache::put( $this->cacheKey, serialize( $galleries ), $this->cacheTtl );

		return new Collection( $galleries );
	}

	public function setCacheTtl( $minutes )
	{
		if ( !is_numeric( $minutes) || $minutes < 0 || $minutes > 100 ) return;
		$this->cacheTtl = $minutes;
	}
}
