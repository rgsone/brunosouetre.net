<?php

namespace BSouetre\Site\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * Class Link
 * @package BSouetre\Site\Models
 */
class Link extends Model
{
	use Validation;

    public $table = 'bsouetre_site_links';

    protected $guarded = ['*'];
    protected $fillable = [];

    public $timestamps = false;

	public $rules = [
		'name' => 'required|between:1,512',
		'url' => 'required|between:1,512|url'
	];

	public $customMessages = [
		'name.required' => 'Un nom pour le lien doit être renseigné.',
		'name.between' => 'Le nom du lien doit comporter 512 caractéres maximum.',
		'url.required' => 'Une url doit être renseignée.',
		'url.between' => 'L\'url doit comporter 512 caractéres maximum.',
		'url.url' => 'L\'url doit être valide.'
	];
}
