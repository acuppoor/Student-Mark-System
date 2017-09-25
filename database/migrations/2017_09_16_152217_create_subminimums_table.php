<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubminimumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subminimums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->string('name');
            $table->boolean('for_dp');
            $table->double('threshold');
            $table->timestamps();
        });

        DB::table('subminimums')->insert(
            array(
                'course_id' => 1,
                'name' => "Subminimum 1",
                'for_dp' => 1,
                'threshold' => 95.0
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
        Schema::dropIfExists('subminimums');
    }
}
