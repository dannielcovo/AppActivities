<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statuses', function (Blueprint $table) {
			$table->increments('id');
			$table->enum('status',\App\Activity::ACTIVITY_STATUS);
			$table->timestamps();
		});

		// Insert some stuff
		DB::table('statuses')->insert(
			array(
				array('status'=>'Pendente'),
				array('status'=>'Em Desenvolvimento'),
				array('status'=>'Em Teste'),
				array('status'=>'Concluído')
			)
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('statuses');
	}
}
