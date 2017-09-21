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
            $table->integer('coursework_id');
            $table->integer('subcoursework_id');
            $table->integer('section_id');
            $table->double('weighting');
            $table->timestamps();
        });
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
