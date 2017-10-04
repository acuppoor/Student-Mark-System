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
                array('role' => 'Student'),
                array('role' => 'Teaching Assistant'),
                array('role' => 'Lecturer'),
                array('role' => 'Course Convenor'),
                array('role' => 'Department Admin'),
                array('role' => 'System Admin')
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
