<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('student_number');
            $table->string('employee_id');
            $table->string('academic_program');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('approved');
            $table->integer("role_id");
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'first_name' => 'Kushal',
                'last_name' => 'Cuppoor',
                'student_number' => 'cppkus001',
                'employee_id' => 1234567,
                'academic_program' => 'EB805',
                'email' => 'cppkus001@myuct.ac.za',
                'password' => bcrypt('1234567'),
                'role_id' => 6,
                'approved' => '1'
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
        Schema::dropIfExists('users');
    }
}
