<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_gallery', function (Blueprint $table) {
	        Schema::create('app_gallery', function (Blueprint $table) {
		        $table->increments('id');
		        $table->integer('parent_id')->nullable();
		        $table->string('name');
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
        Schema::table('app_gallery', function (Blueprint $table) {
	        Schema::dropIfExists('app_gallery');
        });
    }
}
