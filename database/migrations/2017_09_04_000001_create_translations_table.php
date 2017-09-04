<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('translations', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('word_id');
			$table->string('language', 5);
			$table->string('key');
			$table->boolean('is_verified')->default(false);
			$table->timestamps();

			$table->foreign('word_id')->references('id')->on('words');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('translations');
	}
}