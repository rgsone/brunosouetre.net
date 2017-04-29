<?php

namespace BSouetre\Site\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use BSouetre\Site\Models\Setting as SettingModel;

/**
 * Class Settings
 * @package BSouetre\Site\Controllers
 */
class Settings extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController'
    ];

    public $formConfig = 'config_form.yaml';

	public $requiredPermissions = [ 'bsouetre.site.access_settings' ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext( 'BSouetre.Site', 'site', 'settings' );
    }

	public function index()
	{
		$this->asExtension( 'FormController' )->update();
	}

	public function index_onSave()
	{
		return $this->asExtension( 'FormController' )->update_onSave();
	}

	public function formFindModelObject()
	{
		return SettingModel::instance();
	}
}
