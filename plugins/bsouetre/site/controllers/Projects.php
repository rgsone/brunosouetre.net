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

	public function create( $context = null )
	{
		$this->bodyClass = 'compact-container';
		return $this->asExtension('FormController')->create( $context );
	}

	public function listOverrideColumnValue( $record, $columnName, $definition = null )
	{
		# override category column
		# check if the project is bind to an existing category
		if ( $columnName === 'category_id' && empty( $record->category_id ) )
			return '<span style="color: red;">Ce projet n\'est associé à aucune catégorie</span>';

		# override published column
		# convert 1 or 0 value to 'yes' or 'no'
		if ( $columnName === 'published' )
			return ( $record->published < 1 ) ? 'non' : 'oui';
	}
}
