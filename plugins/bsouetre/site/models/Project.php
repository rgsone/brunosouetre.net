<?php

namespace BSouetre\Site\Models;

use Cms\Classes\Controller;
use Cms\Classes\Page;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;

/**
 * Class Project
 * @package BSouetre\Site\Models
 */
class Project extends Model
{
	use Validation;
	use Sluggable;

    public $table = 'bsouetre_site_projects';

    protected $guarded = ['*'];
    protected $fillable = [];

    public $belongsToMany = [
    	'tags' => [
			'BSouetre\Site\Models\Tag',
			'table' => 'bsouetre_site_project_tag',
			'order' => 'name'
		]
	];

	public $belongsTo = [
		'category' => [ 'BSouetre\Site\Models\Category', 'key' => 'category_id' ]
	];

	public $attachOne = [
		'cover_thumb' => 'System\Models\File'
	];

	protected $slugs = [ 'slug' => 'title' ];

	public $rules = [
		'title' => 'required|between:1,1024',
		'content' => 'required',
		'date' => 'required'
	];

	public $customMessages = [
		'title.required' => 'Il n\'y a aucun titre.',
		'title.between' => 'Le titre est trop long (1024 caractéres maximum).',
		'content.required' => 'Il n\'y a aucune description.',
		'date.required' => 'Il n\'y a aucune date.',
	];

	/** @var null|array */
	protected $thumbDimensions = null;

	public function beforeSave()
	{
		# regenerate slug
		$this->slug = null;
		$this->slugAttributes();

		# set category_id to null if not exist and is empty
		if ( !isset( $this->category_id ) || empty( $this->category_id ) )
			$this->category_id = null;
	}

	/**
	 * @param string $pageName
	 * @param Controller $controller
	 */
	public function setUrl( $pageName, $controller )
	{
		$this->url = $controller->pageUrl( $pageName, [ 'name' => $this->slug ] );
	}

	/**
	 * @return array Return an array with width and height dimension of attached file
	 */
	public function getThumbDimensions()
	{
		if ( null === $this->cover_thumb ) return null;

		if ( null !== $this->thumbDimensions && is_array( $this->thumbDimensions ) ) return $this->thumbDimensions;

		list( $thumbBaseWidth, $thumbBaseHeight ) = getimagesize( $this->cover_thumb->getLocalPath() );

		$this->thumbDimensions = [
			'width' => $thumbBaseWidth,
			'height' => $thumbBaseHeight,
			'ratio' => $thumbBaseWidth / $thumbBaseHeight,
			'height_percent_ratio' => ( $thumbBaseHeight / $thumbBaseWidth ) * 100
		];

		return $this->thumbDimensions;
	}

	public function getPreviewAttribute()
	{
		return Page::url( 'project', [ 'name' => $this->slug ] );
	}
}
