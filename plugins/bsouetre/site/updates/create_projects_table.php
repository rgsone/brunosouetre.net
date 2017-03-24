<?php

namespace BSouetre\Site\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use October\Rain\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create( 'bsouetre_site_projects', function( Blueprint $table ) {

            $table->engine = 'InnoDB';

            $table->increments( 'id' );
            $table->string( 'title', 1024 );
            $table->string( 'slug' )->unique()->index();
            $table->text( 'content' )->nullable();
            $table->integer( 'category_id', false, true )->index()->nullable();
            $table->boolean( 'published' )->default( true );
            $table->boolean( 'private' )->default( false );
            $table->boolean( 'featured' )->default( false );
            $table->dateTime( 'date' );
            $table->boolean( 'show_date' )->default( false );
            $table->string( 'date_format', 1 )->default( 1 );

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists( 'bsouetre_site_projects' );
    }
}
