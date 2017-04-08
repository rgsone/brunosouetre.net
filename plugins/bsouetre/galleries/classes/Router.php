<?php

namespace BSouetre\Galleries\Classes;

use Symfony\Component\Finder\Finder;

/**
 * Class Router
 * @package BSouetre\Galleries\Classes
 */
class Router
{
	/** @var string */
	protected $dirAllowPattern = '/^[a-z0-9_\-]+$/';
	/** @var string */
	protected $basePath = '';
	/** @var array|null */
	protected $urlMap = null;
	/** @var array */
	protected $cache = [];

	public function __construct( $basePath )
	{
		$this->basePath = $basePath;
	}

	protected function populateUrlMap()
	{
		if ( null === $this->urlMap )
		{
			$directories = new Finder();
			$directories->in( $this->basePath )
				->directories()
				->name( $this->dirAllowPattern )
				->sortByName()
				->depth( '0' );

			if ( $directories->count() < 1 )
			{
				$this->urlMap = [];
			}
			else
			{
				foreach ( $directories as $dir )
					$this->urlMap[ $dir->getFilename() ] = $dir->getPathname();
			}
		}
	}

	/**
	 * @return array|null
	 */
	public function getUrlMap()
	{
		$this->populateUrlMap();
		return $this->urlMap;
	}

	public function forUrl( $url )
	{
		$this->populateUrlMap();

		if ( !array_key_exists( $url, $this->urlMap ) ) return null;
		if ( array_key_exists( $url, $this->cache ) ) return $this->cache[ $url ];

		return $this->cache[ $url ] = new Gallery( $this->urlMap[ $url ], $url );
	}
}
