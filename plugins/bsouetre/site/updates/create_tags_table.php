<?php

namespace BSouetre\Site\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use October\Rain\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
	public function up()
	{
    	Schema::create( 'bsouetre_site_tags', function( Blueprint $table ) {

			$table->engine = 'InnoDB';

			$table->increments( 'id' );
			$table->string( 'name', 100 )->unique();
			$table->string( 'slug', 100 )->unique();

    	});

		Schema::create( 'bsouetre_site_project_tag', function( Blueprint $table ) {

			$table->engine = 'InnoDB';

			$table->integer( 'tag_id' )->unsigned()->nullable()->default( null );
			$table->integer( 'project_id' )->unsigned()->nullable()->default( null );

			$table->index([ 'tag_id', 'project_id' ]);
			$table->foreign( 'tag_id' )->references( 'id' )->on( 'bsouetre_site_tags' )->onDelete( 'cascade' );
			$table->foreign( 'project_id')->references( 'id' )->on( 'bsouetre_site_projects' )->onDelete( 'cascade' );

		});
	}

	public function down()
	{
		Schema::dropIfExists( 'bsouetre_site_tags' );
		Schema::dropIfExists( 'bsouetre_site_project_tag' );
	}
}
