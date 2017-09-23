<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->text('description');
            $table->integer('term_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('type_id');
            $table->integer('department_id');
            $table->timestamps();
        });

        DB::table('courses')->insert(
            array(
                'name' => 'CSC1016S',
                'code' => 'CSC1016S',
                'description' => 'Computer Science',
                'term_number' => 1171,
                'start_date' => \Carbon\Carbon::create(2017, 8, 16),
                'end_date' => \Carbon\Carbon::create(2017, 11, 11),
                'type_id' => 2,
                'department_id' => 1
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
        Schema::dropIfExists('courses');
    }
}
