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
		'name.required' => 'Le nom doit être renseigné.',
		'name.between' => 'Le nom est trop long (512 caractéres maximum).',
		'url.required' => 'L\'url doit être renseignée.',
		'url.between' => 'L\'url est trop longue (512 caractéres maximum).',
		'url.url' => 'L\'url n\'est pas valide.'
	];
}
