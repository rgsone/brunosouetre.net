<?php

namespace BSouetre\Galleries\Classes;

use Cms\Classes\Page;
use Illuminate\Support\Facades\Cache;
use October\Rain\Support\Facades\Config;
use October\Rain\Support\Facades\File;
use October\Rain\Support\Facades\Yaml;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class Gallery
 * @package BSouetre\Galleries\Classes
 */
class Gallery
{
	/** @var string Directory path */
	protected $path = '';
	/** @var string Url slug */
	protected $urlSlug = '';
	/** @var bool If config file exist in directory */
	protected $configFileExist = false;
	/** @var string Config file name */
	protected $configFileName = 'config.yml';
	/** @var string Config full path */
	protected $configFilePath = '';
	/** @var string Allowed image extensions regex pattern */
	protected $imagesAllowPattern = '/\.(jpg|jpeg|gif|png)$/';
	/** @var array Config fill with default config */
	protected $config = [
		'slug' => '',
		'random' => false,
		'published' => true,
		'listed' => true,
		'title' => '',
		'date' => '',
		'top_description' => '',
		'description' => ''
	];
	/** @var array */
	protected $data = [
		'url' => null,
		'images' => null
	];
	/** @var int */
	protected $imagesCount = 0;
	/** @var bool */
	protected $refreshCache = false;
	/** @var int In minutes */
	protected $cacheTtl = 1;
	/** @var string */
	protected $cacheKey;

	/**
	 * Gallery constructor.
	 * @param $dirPath
	 * @param $urlSlug
	 */
	public function __construct( $dirPath, $urlSlug )
	{
		$this->path = $dirPath;
		$this->config['slug'] = $this->urlSlug = $urlSlug;
		$this->configFilePath = $this->path . DIRECTORY_SEPARATOR . $this->configFileName;
		$this->data['url'] = Page::url( 'gallery', [ 'name' => $this->urlSlug ] );
		$this->cacheKey = crc32( 'galleries-gallery-images-map' );
		$this->parseConf();
	}

	protected function parseConf()
	{
		if ( !File::exists( $this->configFilePath ) ) return;
		$userConfig = Yaml::parse( File::get( $this->configFilePath ) );
		$this->config = array_merge( $this->config, $userConfig );
	}

	/**
	 * Get and parse images information
	 * By default model do not call this method,
	 * if directory images are wanted,
	 * call this method to populate models
	 */
	public function getImages()
	{
		# get from cache if exists

		$cached = Cache::get( $this->cacheKey, false );

		if ( $cached && $this->refreshCache === false )
		{
			$data = @unserialize( $cached );
			if ( $data !== false )
			{
				$this->data['images'] = $data;
				return;
			}
		}

		# get images and parse info

		$images = Finder::create()
			->in( $this->path )
			->files()
			->depth( 0 )
			->name( $this->imagesAllowPattern )
			->sortByName();

		# skip if dir is empty
		if ( $images->count() <= 0 ) return;

		# populate
		$baseFileUrl = Config::get( 'bsouetre.galleries::baseFileUrl', '' ) . '/' . $this->urlSlug;
		/** @var SplFileInfo $img */
		foreach ( $images as $img )
			$this->data['images'][] = new GalleryImage( $img, $baseFileUrl );

		# randomize images if set
		if ( $this->random )
			shuffle( $this->data['images'] );

		$this->imagesCount = count( $this->data['images'] );

		# cache results

		Cache::put( $this->cacheKey, serialize( $this->data['images'] ), $this->cacheTtl );
	}

	/**
	 * @param bool $value Force cache refresh if true
	 */
	public function setCacheRefresh( $value )
	{
		$this->refreshCache = ( $value === true ) ? true : false;
	}

	/**
	 * @param float $minutes Set cache live in minutes
	 */
	public function setCacheTtl( $minutes )
	{
		if ( !is_numeric( $minutes) || $minutes < 0 || $minutes > 100 ) return;
		$this->cacheTtl = $minutes;
	}

	public function __get( $name )
	{
		if ( array_key_exists( $name, $this->config ) )
			return $this->config[ $name ];

		if ( array_key_exists( $name, $this->data ) )
			return $this->data[ $name ];

		return null;
	}

	public function __isset( $name )
	{
		if ( isset( $this->config[ $name ] ) || isset( $this->data[ $name ] ) )
			return true;

		return false;
	}
}
