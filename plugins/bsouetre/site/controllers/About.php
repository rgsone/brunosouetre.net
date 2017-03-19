<?php

namespace BSouetre\Site\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use BSouetre\Site\Models\About as AboutModel;

/**
 * Class About
 * @package BSouetre\Site\Controllers
 */
class About extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController'
    ];

    public $formConfig = 'config_form.yaml';

	public $requiredPermissions = [ 'bsouetre.site.access_about' ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext( 'BSouetre.Site', 'site', 'about' );
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
		return AboutModel::instance();
	}
}
