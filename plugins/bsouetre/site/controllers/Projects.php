<?php

namespace BSouetre\Site\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

/**
 * Class Projects
 * @package BSouetre\Site\Controllers
 */
class Projects extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext( 'BSouetre.Site', 'site', 'projects' );
    }
}
