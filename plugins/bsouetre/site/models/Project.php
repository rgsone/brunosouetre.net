<?php

namespace BSouetre\Site\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * Class Project
 * @package BSouetre\Site\Models
 */
class Project extends Model
{
	use Validation;

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

	public $rules = [
		'title' => 'required|between:1,1024'
	];

	public $customMessages = [
		'title.required' => 'Le titre n\'est pas renseigné.',
		'title.between' => 'Le titre est trop long (1024 caractéres maximum).'
	];
}
