<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_languages', function (Blueprint $table) {
	        Schema::create('app_languages', function (Blueprint $table) {
		        $table->increments('id');
		        $table->string('text');
		        $table->string('iso_code');
		        $table->boolean('status');
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
        Schema::table('app_languages', function (Blueprint $table) {
	        Schema::dropIfExists('app_languages');
        });
    }
}
