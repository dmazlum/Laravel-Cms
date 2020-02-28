<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('app_products_categories', function (Blueprint $table) {
		    Schema::create('app_products_categories', function (Blueprint $table) {
			    $table->increments('id');
			    $table->integer('parent_id');
			    $table->string('name');
			    $table->string('content');
			    $table->char('photo');
			    $table->char('slug');
			    $table->char('language');
			    $table->integer('sorting');
			    $table->boolean('status');
			    $table->timestamps();
		    });
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('app_products_categories', function (Blueprint $table) {
		    Schema::dropIfExists('app_products_categories');
	    });
    }
}
