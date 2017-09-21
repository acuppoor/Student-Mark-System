<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subcoursework_id');
            $table->string('name');
            $table->double('max_marks');
            $table->timestamps();
        });

        DB::table('sections')->insert(
            array(
                'subcoursework_id' => 1,
                'name' => 'Section 1',
                'max_marks' => 100.0
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
        Schema::dropIfExists('sections');
    }
}
