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
            $table->string('firstName');
            $table->string('lastName');
            $table->string('studentNumber');
            $table->string('employeeID');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('approved');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'firstName' => 'Kushal',
                'lastName' => 'Cuppoor',
                'studentNumber' => 'cppkus001',
                'employeeID' => 1234567,
                'email' => 'cppkus001@myuct.ac.za',
                'password' => bcrypt('1234567'),
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
