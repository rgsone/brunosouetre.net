<?php

namespace BSouetre\Site\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

/**
 * Class Links
 * @package BSouetre\Site\Controllers
 */
class Links extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

	public $requiredPermissions = [ 'bsouetre.site.access_links' ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext( 'BSouetre.Site', 'site', 'links' );
		$this->pageTitle = 'Gestion des liens';
    }
}
