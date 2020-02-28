<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_pages', function (Blueprint $table) {
	        Schema::create('app_pages', function (Blueprint $table) {
		        $table->increments('id');
		        $table->integer('parent_id');
		        $table->string('name');
		        $table->char('slug');
		        $table->string('section_url')->nullable();
		        $table->string('content');
		        $table->string('seo_desc')->nullable();
		        $table->string('seo_keywords')->nullable();
		        $table->integer('sorting');
		        $table->char('language');
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
        Schema::table('app_pages', function (Blueprint $table) {
	        Schema::dropIfExists('app_pages');
        });
    }
}
