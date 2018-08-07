<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTablePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('card_number');
            $table->string('sadad_olp');
            $table->string('payment_option');
            $table->string('expiry_date');
            $table->string('customer_ip');
            $table->integer('status');
            $table->integer('payment_status');
            $table->string('fort_id');
            $table->string('signature');
            $table->double('amount',13,2);
            $table->string('order_number');
            $table->string('currency');
            $table->text('authorization_code');
            $table->text('order_description');
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
        Schema::dropIfExists('payment');

    }
}
