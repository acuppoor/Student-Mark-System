<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalGradeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_grade_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('final_grade_types')->insert(
            array(
                array('name' => 'Show Grade'),
                array('name' => 'AB'),
                array('name' => 'ASF'),
                array('name' => 'ATT'),
                array('name' => 'DE'),
                array('name' => 'DPR'),
                array('name' => 'EXA'),
                array('name' => 'F 0-49%'),
                array('name' => 'FS 0-49%'),
                array('name' => 'GIP'),
                array('name' => 'INC'),
                array('name' => 'OS'),
                array('name' => 'OSS'),
                array('name' => 'PA'),
                array('name' => 'SF'),
                array('name' => 'SP'),
                array('name' => 'UF SM'),
                array('name' => 'UP')
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
        Schema::dropIfExists('final_grade_types');
    }
}
