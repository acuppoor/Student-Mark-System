<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubminimumColumnMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subminimum_column_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subminimum_id');
            $table->integer('coursework_id');
            $table->integer('subcoursework_id')->default(-1);
            $table->double('weighting');
            $table->timestamps();
        });

        DB::table('subminimum_column_maps')->insert(
            array(
                'subminimum_id' => 1,
                'coursework_id' => 1,
                'subcoursework_id' => "1",
                'weighting' => 1
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
        Schema::dropIfExists('subminimum_column_maps');
    }
}
