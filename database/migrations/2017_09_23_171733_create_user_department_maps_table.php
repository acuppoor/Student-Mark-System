<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDepartmentMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_department_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('department_id');
            $table->boolean('status');
            $table->timestamps();
        });

        DB::table('user_department_maps')->insert(
            array(
                'user_id' => 1,
                'department_id' => 1,
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
        Schema::dropIfExists('user_department_maps');
    }
}
