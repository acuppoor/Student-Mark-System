<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCourseworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_courseworks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coursework_id');
            $table->string('name');
            $table->boolean('display_marks');
            $table->boolean('display_to_percentage');
            $table->boolean('include_in_coursework');
            $table->boolean('weighting_in_coursework');
            $table->double('max_marks');
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
        Schema::dropIfExists('sub_courseworks');
    }
}
