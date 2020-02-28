<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class AppThemes extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('app_themes', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('module_id');
				$table->string('theme_name');
				$table->text('theme_context');
				$table->char('status', 1);
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('app_themes');
		}
	}
