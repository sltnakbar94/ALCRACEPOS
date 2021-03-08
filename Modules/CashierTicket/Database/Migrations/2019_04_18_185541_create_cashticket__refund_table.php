<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashticketRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashticket__refund', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->nullable();
            $table->string('code')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('subtotal')->nullable();
            $table->bigInteger('disc')->nullable();
            $table->string('notes')->nullable();
            $table->integer('refunded_by')->nullable();
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
        Schema::dropIfExists('cashticket__refund');
    }
}
