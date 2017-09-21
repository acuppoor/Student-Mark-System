<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseworkTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursework_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('coursework_types')->insert(
            array(
                array('name' => 'Assignment'),
                array('name' => 'Exam'),
                array('name' => 'Other'),
                array('name' => 'Practical'),
                array('name' => 'Practical Test'),
                array('name' => 'Quiz'),
                array('name' => 'Test')
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
        Schema::dropIfExists('coursework_types');
    }
}
