<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreatePasswordResets extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			if (!Schema::hasTable('app_password_resets')) {
				Schema::create('app_password_resets', function (Blueprint $table) {
					$table->string('email')->index();
					$table->string('token');
					$table->timestamp('created_at')->nullable();
				});
			}
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('app_password_resets');
		}
	}
