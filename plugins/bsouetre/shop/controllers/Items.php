<?php

namespace BSouetre\Shop\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

/**
 * Class Items
 * @package BSouetre\Shop\Controllers
 */
class Items extends Controller
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
        BackendMenu::setContext( 'BSouetre.Shop', 'shop', 'items' );
    }
}
