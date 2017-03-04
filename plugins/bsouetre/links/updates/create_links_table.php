<?php

namespace BSouetre\Links\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use October\Rain\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    public function up()
    {
        Schema::create( 'bsouetre_links_links', function( Blueprint $table ) {

        	$table->engine = 'InnoDB';

        	$table->increments( 'id' );
        	$table->string( 'name', 512 );
        	$table->string( 'url', 512 );

        });
    }

    public function down()
    {
        Schema::dropIfExists( 'bsouetre_links_links' );
    }
}
