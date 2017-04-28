<?php

namespace BSouetre\Galleries\Classes;

use October\Rain\Database\Attach\Resizer;
use October\Rain\Support\Facades\File;
use \SplFileInfo;

/**
 * Class GalleryImage
 * @package BSouetre\Galleries\Classes
 */
class GalleryImage
{
	/** @var string Image file fullname */
	protected $fullname;
	/** @var string Image file name without extension */
	protected $name;
	/** @var string Image file extension without dot */
	protected $ext;
	/** @var string Image file path without filename */
	protected $basePath;
	/** @var string Image file path with filename */
	protected $fullPath;
	/** @var array Image dimensions (with, height, ratio, height percent ratio */
	protected $dimensions;
	/** @var string Base url */
	protected $baseUrl;
	/** @var string Image full url */
	protected $url;
	/** @var string Thumb directory name */
	protected $thumbDirname = 'thumb';
	/** @var string Thumb directory path */
	protected $thumbPath;

	/**
	 * GalleryImage constructor.
	 * @param SplFileInfo $fileInfo
	 */
	public function __construct( SplFileInfo $fileInfo, $baseUrl )
	{
		$this->fullname = $fileInfo->getFilename();
		$this->ext = $fileInfo->getExtension();
		$this->name = $fileInfo->getBasename( '.' . $this->ext );

		$this->fullPath = $fileInfo->getPathname();
		$this->basePath = $fileInfo->getPath();

		$this->baseUrl = rtrim( $baseUrl, '/' );
		$this->url = $this->baseUrl . '/' . $this->fullname;

		$this->thumbPath = $this->basePath . DIRECTORY_SEPARATOR . $this->thumbDirname;

		$this->dimensions = $this->getDimensions();
	}

	protected function getDimensions()
	{
		list( $width, $height ) = getimagesize( $this->fullPath );

		return [
			'width' => $width,
			'height' => $height,
			'ratio' => $width / $height,
			'height_percent_ratio' => ( $height / $width ) * 100,
			'width_percent_ratio' => ( $width / $height ) * 100
		];
	}

	protected function getThumbFilename( $width, $height )
	{
		$widthStr = ( $width < 1 ) ? 'auto' : $width;
		$heightStr = ( $height < 1 ) ? 'auto' : $height;

		return 'thumb_' . $widthStr . 'x' . $heightStr . '_' . $this->fullname;
	}

	protected function isThumbExist( $path )
	{
		return File::exists( $path );
	}

	protected function createThumbDir()
	{
		if ( !File::exists( $this->thumbPath ) )
			File::makeDirectory( $this->thumbPath, 0777, true );
	}

	protected function createThumb( $thumbPathname, $width, $height )
	{
		$this->createThumbDir();

		Resizer::open( $this->fullPath )
			->resize( $width, $height, [ 'mode' => 'auto', 'extension' => 'auto' ] )
			->save( $thumbPathname );
	}

	public function getThumb( $width = 0, $height = 0 )
	{
		$width = (int)$width;
		$height = (int)$height;

		# if image dimensions == expected dimensions or
		# if image dimensions < expected dimensions or
		# if expected dimensions are < 1
		# return base image url
		if ( ( $width < 1 && $height < 1 ) || $width > $this->dimensions['width'] || $height > $this->dimensions['height'] ||
			 ( $width === $this->dimensions['width'] && $height === $this->dimensions['height'] ) )
		{
			return $this->url;
		}

		$thumbFilename = $this->getThumbFilename( $width, $height );
		$thumbFullPathname = $this->thumbPath . DIRECTORY_SEPARATOR . $thumbFilename;
		$thumbUrl = $this->baseUrl . '/' . $this->thumbDirname . '/' . $thumbFilename;

		if ( !$this->isThumbExist( $thumbFullPathname ) )
			$this->createThumb( $thumbFullPathname, $width, $height );

		return $thumbUrl;
	}

	public function getWidthForHeight( $height = 0 )
	{
		if ( $height < 1 ) return 0;
		return $this->dimensions['ratio'] * $height;
	}

	public function __get( $name )
	{
		if ( isset( $this->{ $name } ) )
			return $this->{ $name };

		return null;
	}

	public function __isset( $name )
	{
		return isset( $this->{ $name } );
	}
}
