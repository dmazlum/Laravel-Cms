<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateProductPhotosTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('app_products_photos', function (Blueprint $table) {
				Schema::create('app_products_photos', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('parent_id')->unsigned();
					$table->foreign('parent_id')->references('id')->on('app_products');
					$table->string('photo_name');
					$table->integer('sorting');
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
			Schema::table('app_products_photos', function (Blueprint $table) {
				Schema::dropIfExists('app_products_photos');
			});
		}
	}
