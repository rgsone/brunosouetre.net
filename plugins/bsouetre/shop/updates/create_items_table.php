<?php

namespace BSouetre\Shop\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use October\Rain\Support\Facades\Schema;

/**
 * Class CreateItemsTable
 * @package BSouetre\Shop\Updates
 */
class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create( 'bsouetre_shop_items', function( Blueprint $table ) {

            $table->engine = 'InnoDB';

            $table->increments( 'id' );
            $table->string( 'title', 1024 );
            $table->string( 'slug' )->unique()->index();
            $table->text( 'description' )->default( null )->nullable();
            //$table->decimal( 'price', 7, 2 )->default( 0.0 );
            //$table->boolean( 'has_price' )->default( true );
            $table->boolean( 'published' )->default( true );
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists( 'bsouetre_shop_items' );
    }
}
