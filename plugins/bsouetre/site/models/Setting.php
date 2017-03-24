<?php

namespace BSouetre\Site\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * Class Setting
 * @package BSouetre\Site\Models
 */
class Setting extends Model
{
    use Validation;

	public $implement = [ 'System.Behaviors.SettingsModel' ];
	public $settingsCode = 'bsouetre_site_settings';
	public $settingsFields = 'fields.yaml';

	public $attachOne = [
		'highlighted_item_img' => 'System\Models\File'
	];

	public $rules = [
		'email' => 'required|email',
		'highlighted_item_desc' => 'max:1024',
		'highlighted_item_url' => 'max:512|url'
	];

	public $customMessages = [
		'email.required' => 'L\'email n\'est pas renseigné.',
		'email.email' => 'L\'email n\'est pas valide.',
		'highlighted_item_desc.max' => 'La description de l\'article mise en avant est trop longue (1024 caractéres maximum).',
		'highlighted_item_url.max' => 'L\'URL de l\'article mise en avant est trop longue (1024 caractéres maximum).',
		'highlighted_item_url.url' => 'L\'URL de l\'article mise en avant n\'est pas valide.'
	];
}
