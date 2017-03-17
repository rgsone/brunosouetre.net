<?php

namespace BSouetre\Site\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use October\Rain\Support\Facades\Schema;


/**
 * Class CreateCategoriesTable
 * @package BSouetre\Site\Updates
 */
class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create( 'bsouetre_site_categories', function( Blueprint $table ) {

        	$table->engine = 'InnoDB';

        	$table->increments( 'id' );
        	$table->string( 'name', 255 );
			//$table->string( 'slug' )->nullable()->index();
        	$table->string( 'color', 10 )->default( '#000066' );
			$table->string( 'description', 1024 )->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists( 'bsouetre_site_categories' );
    }
}
