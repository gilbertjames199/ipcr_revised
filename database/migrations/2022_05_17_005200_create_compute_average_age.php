<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputeAverageAge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `get_average_age`;
            CREATE PROCEDURE `get_average_age` ()
            BEGIN
            SELECT AVG(y01_personal_infos.ageinyears) as 'ave_age' FROM y01_personal_infos;
            END;";
  
        \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('compute_average_age');
    }
}
