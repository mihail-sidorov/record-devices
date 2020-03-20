<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('model');
            $table->string('serial_number');
            $table->integer('type_device_id');
            $table->integer('receipt_date');
            $table->string('purchase_price');
            $table->integer('warranty');
            $table->integer('worker_id');
            $table->integer('provider_id');
            $table->integer('responsibles_id');
            $table->string('status')->default('store');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
