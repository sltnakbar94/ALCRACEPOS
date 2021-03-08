<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->dateTime('open_at')->nullable();
            $table->dateTime('close_at')->nullable();
            $table->bigInteger('beginning_cash')->nullable();
            $table->bigInteger('total_transaction')->nullable();
            $table->bigInteger('expected_cash')->nullable();
            $table->bigInteger('actual_cash')->nullable();
            $table->bigInteger('difference')->nullable();
            $table->bigInteger('refund')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('shift');
    }
}
