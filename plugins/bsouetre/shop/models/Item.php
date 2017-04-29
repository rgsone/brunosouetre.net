<?php

namespace BSouetre\Shop\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;

class Item extends Model
{
	use Validation;
	use Sluggable;

    public $table = 'bsouetre_shop_items';

    protected $guarded = ['*'];
    protected $fillable = [];

	protected $slugs = [ 'slug' => 'title' ];

	public $rules = [
		'title' => 'required|max:1024',
		'description' => 'required'
	];

	public $customMessages = [
		'title.required' => 'Il n\'y a aucun titre.',
		'title.max' => 'Le titre est trop long (1024 caractéres maximum).',
		'description.required' => 'Il n\'y a aucune description.'
	];

	public function beforeSave()
	{
		# regenerate slug
		$this->slug = null;
		$this->slugAttributes();
	}

	/**
	 * @param string $pageName
	 * @param Controller $controller
	 */
	public function setUrl( $pageName, $controller )
	{
		$this->url = $controller->pageUrl( $pageName, [ 'name' => $this->slug ] );
	}
}
