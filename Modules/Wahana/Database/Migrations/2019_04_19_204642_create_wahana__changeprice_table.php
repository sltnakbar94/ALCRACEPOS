<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWahanaChangepriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wahana__changeprice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('wahana_id')->nullable();
            $table->bigInteger('previous_price')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('notes')->nullable();
            $table->enum('status',['Waiting Approval','Approved','Not Approved'])->nullable();
            $table->integer('processed_by')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wahana__changeprice');
    }
}
