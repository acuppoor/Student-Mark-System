<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role');
        });

        DB::table('roles')->insert(
            array(
                array('role' => 'student'),
                array('role' => 'teaching_assistant'),
                array('role' => 'lecturer'),
                array('role' => 'course_convenor'),
                array('role' => 'department_admin'),
                array('role' => 'system_admin')
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
        Schema::dropIfExists('roles');
    }
}
