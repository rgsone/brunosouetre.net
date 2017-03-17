<?php

namespace BSouetre\Site\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

/**
 * Class Tags
 * @package BSouetre\Site\Controllers
 */
class Tags extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

	public $requiredPermissions = [ 'bsouetre.site.access_tags' ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext( 'BSouetre.Site', 'site', 'tags' );
		$this->pageTitle = 'Gestion des tags';

	}
}
