<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceWorkerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_worker', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id');
            $table->integer('worker_id');
            $table->integer('act_give_id')->nullable()->default(null);
            $table->integer('act_return_id')->nullable()->default(null);
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
        Schema::dropIfExists('device_worker');
    }
}
