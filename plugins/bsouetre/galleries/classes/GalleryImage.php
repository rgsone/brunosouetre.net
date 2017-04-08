<?php

namespace BSouetre\Galleries\Classes;

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
	/** @var string Image full url */
	protected $url;

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

		$this->url = rtrim( $baseUrl, '/' ) . '/' . $this->fullname;

		$this->dimensions = $this->getDimensions();
	}

	protected function getDimensions()
	{
		list( $width, $height ) = getimagesize( $this->fullPath );

		return [
			'width' => $width,
			'height' => $height,
			'ratio' => $width / $height,
			'height_percent_ratio' => ( $height / $width ) * 100
		];
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
