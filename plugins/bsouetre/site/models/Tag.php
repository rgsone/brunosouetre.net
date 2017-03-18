<?php

namespace BSouetre\Site\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;

/**
 * Class Tag
 * @package BSouetre\Site\Models
 */
class Tag extends Model
{
	use Validation;
	use Sluggable;

    public $table = 'bsouetre_site_tags';

    protected $guarded = ['*'];
    protected $fillable = [];

	public $timestamps = false;

    public $belongsToMany = [
    	'projects' => [
			'BSouetre\Site\Models\Project',
			'table' => 'bsouetre_site_project_tag',
			'order' => 'published_at desc'
		]
	];

	protected $slugs = [ 'slug' => 'name' ];

	public $rules = [
		'name' => 'required|between:1,100|unique:bsouetre_site_tags'
	];

	public $customMessages = [
		'name.required' => 'Le nom n\'est pas renseigné.',
		'name.between' => 'Le nom est trop long (100 caractéres maximum).',
		'name.unique' => 'Le nom existe déjà.'
	];

	public function beforeSave()
	{
		$this->slug = null;
		$this->slugAttributes();
	}
}
