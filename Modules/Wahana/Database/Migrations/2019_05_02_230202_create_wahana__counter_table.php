<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWahanaCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wahana__counter', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->nullable();
            $table->string('counter_number')->nullable();
            $table->string('name')->nullable();
            $table->datetime('start_at')->nullable();
            $table->datetime('end_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wahana__counter');
    }
}
