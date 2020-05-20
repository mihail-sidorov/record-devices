<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkPlaceComponentPartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_place_component_part', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_place_id');
            $table->integer('component_part_id');
            $table->timestamps();
            $table->boolean('attach')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_place_component_part');
    }
}
