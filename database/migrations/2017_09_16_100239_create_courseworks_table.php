<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courseworks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->string("name");
            $table->integer('coursework_type_id');
            $table->boolean('display_to_students');
            $table->boolean('include_in_classrecord');
            $table->integer('weighting_in_classrecord');
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
        Schema::dropIfExists('courseworks');
    }
}
