<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
        });

        DB::table('user_types')->insert(
            array(
                array('type' => 'student'),
                array('type' => 'teaching_assistant'),
                array('type' => 'lecturer'),
                array('type' => 'course_convenor'),
                array('type' => 'department_admin'),
                array('type' => 'system_admin')
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
        Schema::dropIfExists('user_types');
    }
}
