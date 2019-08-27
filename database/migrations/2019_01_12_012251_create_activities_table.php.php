<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255)->nullable(false);
			$table->string('description', 600)->nullable(false);
			$table->date('begin_date')->nullable(false);
			$table->date('final_date')->nullable();
			$table->unsignedInteger('status_id');
			$table->unsignedInteger('user_id');
			$table->enum('situation', ['Ativo', 'Inativo'] );
			$table->foreign ('status_id')->references('id')->on('statuses');
			$table->foreign ('user_id')->references('id')->on('users');
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
		Schema::dropIfExists('activities')->onDelete('cascade');
	}
}
