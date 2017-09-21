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
            $table->date('display_to_students');
            $table->boolean('include_in_classrecord');
            $table->double('weighting_in_classrecord');
            $table->timestamps();
        });

        DB::table('courseworks')->insert(
            array(
                'course_id' => 1,
                'name' => 'Assignments',
                'coursework_type_id' => 1,
                'display_to_students' => "2017-08-16",
                'include_in_classrecord' => '1',
                'weighting_in_classrecord' => 35.0
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
        Schema::dropIfExists('courseworks');
    }
}
