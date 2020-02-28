<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateModuleTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('app_modules', function (Blueprint $table) {
				Schema::create('app_modules', function (Blueprint $table) {
					$table->increments('id');
					$table->char('module_name');
					$table->char('sname');
					$table->char('module_icon');
					$table->boolean('module_type');
					$table->char('permission');
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
			Schema::table('app_modules', function (Blueprint $table) {
				Schema::dropIfExists('app_modules');
			});
		}
	}
