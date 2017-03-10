<?php

namespace BSouetre\Site\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * Class About
 * @package BSouetre\Site\Models
 */
class About extends Model
{
	use Validation;

	public $implement = [ 'System.Behaviors.SettingsModel' ];
	public $settingsCode = 'bsouetre_site_about_settings';
	public $settingsFields = 'fields.yaml';

	public $rules = [
		//'content' => 'required'
	];

	public $customMessages = [
		//'content.required' => 'Le contenu doit être renseignée.'
	];

	public function initSettingsData()
	{
		//$this->content = 'Test';
	}
}
