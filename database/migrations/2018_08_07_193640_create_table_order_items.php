<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->index()->unsigned();
            $table->integer('order_id')->index()->unsigned();
            $table->enum('gender',array('male','female','nogender'));
            $table->string('address');
            $table->string('time');
            $table->date('date');
            $table->text('notes');
            $table->float('order_long',13,2);
            $table->float('order_lat',13,2);
            $table->string('amount');
            $table->string('total');
            $table->integer('status');
            $table->integer('is_express');
            $table->softDeletes();
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
        Schema::dropIfExists('order_items');

    }
}
