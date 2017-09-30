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
            $table->string('first_name')->default('undefined');
            $table->string('last_name')->default('undefined');
            $table->string('student_number')->unique()->default('undefined');
            $table->string('employee_id')->unique()->default('undefined');
            $table->string('email')->default('undefined@undefined.un');
            $table->string('password')->default(bcrypt('1234567'));
            $table->boolean('approved')->default(0);
            $table->boolean('account_registered')->default(0);
            $table->integer("role_id")->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'first_name' => 'Kushal',
                'last_name' => 'Cuppoor',
                'student_number' => 'cppkus001',
                'employee_id' => 1234567,
                'email' => 'cppkus001@myuct.ac.za',
                'password' => bcrypt('1234567'),
                'account_registered' => 1,
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
