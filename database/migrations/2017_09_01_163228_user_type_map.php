<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTypeMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type_map', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('type_id');
        });

        DB::table('user_type_map')->insert(
            array(
                'user_id' => 1,
                'type_id' => 6
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
        Schema::dropIfExists('user_type_map');
    }
}
