<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_socials', function (Blueprint $table) {
	        Schema::create('app_socials', function (Blueprint $table) {
		        $table->increments('id');
		        $table->string('social_name');
		        $table->string('social_url');
		        $table->char('icon');
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
        Schema::table('app_socials', function (Blueprint $table) {
	        Schema::dropIfExists('app_socials');
        });
    }
}
