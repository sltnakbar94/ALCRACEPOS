<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierticketTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashticket__transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shift_id')->nullable();
            $table->text('transaction_number')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('payment',['tunai','debit'])->nullable();
            $table->bigInteger('cash')->nullable();
            $table->bigInteger('change')->nullable();
            $table->enum('ticket_type',['basic','pass'])->nullable()->default('basic');
            $table->bigInteger('cashback')->nullable();
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
        Schema::dropIfExists('cashticket__transaction');
    }
}
