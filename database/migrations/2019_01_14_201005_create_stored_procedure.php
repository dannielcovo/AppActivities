<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStoredProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	$procedure = "
    		CREATE DEFINER=`root`@`localhost` PROCEDURE `select_activity_by_id`(IN idx int)
				BEGIN
					SELECT activities.id, name, status, begin_date, final_date, situation, description, status_id FROM activities 
					JOIN statuses ON activities.status_id = statuses.id
					WHERE activities.id = idx;
				END
    	";

		DB::unprepared("DROP procedure IF EXISTS select_activity_by_id");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::unprepared("DROP procedure IF EXISTS select_activity_by_id");
    }
}
