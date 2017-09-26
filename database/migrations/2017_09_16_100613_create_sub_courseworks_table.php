<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCourseworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_courseworks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coursework_id');
            $table->string('name');
            $table->date('display_to_students');
            $table->boolean('display_marks');
            $table->boolean('display_percentage');
            $table->double('weighting_in_coursework');
            $table->double('max_marks');
            $table->timestamps();
        });

        DB::table('sub_courseworks')->insert(
            array(
                'coursework_id' => 1,
                'name' => 'Assignment 1',
                'display_to_students' => "2017-08-16",
                'display_marks' => '1',
                'display_percentage' => "1",
                'weighting_in_coursework' => 100.0,
                'max_marks' => 100.0
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
        Schema::dropIfExists('sub_courseworks');
    }
}
