<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableCarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->string('device_id');
            $table->string('device_type');
            $table->integer('product_id')->index()->unsigned();
            $table->enum('gender',array('male','female','nogender'));
            $table->integer('amount');
            $table->string('address');
            $table->string('time');
            $table->string('date');
            $table->text('notes');
            $table->integer('total');
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
        Schema::dropIfExists('carts');
    }
}