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

	public $rules = [
		'email' => 'required|email'
	];

	public $customMessages = [
		'email.required' => 'L\'email n\'est pas renseigné.',
		'email.email' => 'L\'email n\'est pas valide.'
	];
}
