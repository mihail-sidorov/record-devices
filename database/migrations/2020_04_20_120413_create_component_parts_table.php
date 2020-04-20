<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('model');
            $table->string('serial_number');
            $table->integer('receipt_date');
            $table->string('purchase_price');
            $table->integer('warranty');
            $table->integer('responsible_id');
            $table->integer('provider_id');
            $table->integer('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_parts');
    }
}
