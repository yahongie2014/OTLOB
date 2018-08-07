<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->enum('status',array(1,2,3,4,5,6,7));
            $table->integer('area_id');
            $table->string('address');
            $table->string('order_id');
            $table->double('total');
            $table->integer('promo_code_id');
            $table->double('total_after_discount');
            $table->integer('payment_type');
            $table->string('payment_no');
            $table->string('payment_image');
            $table->integer('bank_id');
            $table->string('currency_rate');
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
        Schema::dropIfExists('order_product');

    }
}
