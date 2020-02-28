<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class AppNews extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('app_news', function (Blueprint $table) {
				$table->increments('id');
				$table->string('subject');
				$table->text('content');
				$table->string('photo')->nullable();
				$table->string('slug');
				$table->string('language');
				$table->boolean('status');
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
			Schema::dropIfExists('app_news');
		}
	}
