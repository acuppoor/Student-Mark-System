<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCourseMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_course_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('course_id');
            $table->string('academic_program');
            $table->integer('class_number');
            $table->boolean('status'); // 1 means registered, 0 deregistered
            $table->timestamps();
        });

        DB::table('user_course_maps')->insert(
            array(
                'user_id' => 1,
                'course_id' => 1,
                'academic_program' => '12345',
                'class_number' => 9654,
                'status' => 1
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
        Schema::dropIfExists('user_course_maps');
    }
}
