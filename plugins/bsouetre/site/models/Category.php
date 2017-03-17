<?php

namespace BSouetre\Site\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * Class Category
 * @package BSouetre\Site\Models
 */
class Category extends Model
{
	use Validation;

    public $table = 'bsouetre_site_categories';

    protected $guarded = ['*'];
    protected $fillable = [];

	public $timestamps = false;

    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

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
}
