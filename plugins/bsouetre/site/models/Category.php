<?php

namespace BSouetre\Site\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;

/**
 * Class Category
 * @package BSouetre\Site\Models
 */
class Category extends Model
{
	use Validation;
	use Sluggable;

    public $table = 'bsouetre_site_categories';

    protected $guarded = ['*'];
    protected $fillable = [];

	public $timestamps = false;

    public $hasMany = [
		'projects' => [ 'BSouetre\Site\Models\Project', 'key' => 'category_id' ]
	];

	protected $slugs = [ 'slug' => 'name' ];

	public $rules = [
		'name' => 'required|between:1,255',
		'color' => 'between:1,10',
		'description' => 'between:0,1024'
	];

	public $customMessages = [
		'name.required' => 'Un nom doit être renseigné.',
		'name.between' => 'Le nom doit comporter 255 caractéres maximum.',
		'color.between' => 'Le format de définition de la couleur est incorrect.',
		'description.between' => 'La description doit comporter 1024 caractéres maximum.',
	];

	public function beforeDelete()
	{
		# set to null all references in others tables
		foreach ( $this->projects as $project )
		{
			$project->category_id = null;
			$spotZone->save();
		}
	}

	public function beforeSave()
	{
		# regenerate slug
		$this->slug = null;
		$this->slugAttributes();
	}
}
