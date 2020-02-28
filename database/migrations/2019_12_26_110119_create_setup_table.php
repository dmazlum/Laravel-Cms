<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateSetupTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('app_setup', function (Blueprint $table) {
				Schema::create('app_setup', function (Blueprint $table) {
					$table->increments('id');
					$table->string('config_label');
					$table->string('config_name');
					$table->string('config_value');
					$table->string('config_help_text');
					$table->string('config_section');
					$table->string('config_input_type');
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
			Schema::table('app_setup', function (Blueprint $table) {
				Schema::dropIfExists('app_setup');
			});
		}
	}
