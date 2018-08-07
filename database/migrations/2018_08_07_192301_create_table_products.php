<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->integer('cat_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('views');
            $table->text('desc');
            $table->string('img');
            $table->double('price');
            $table->integer('is_hidden');
            $table->string('prepration_time');
            $table->integer('status');
            $table->integer('max_num');
            $table->integer('is_product')->default(0);
            $table->integer('is_express')->default(0);
            $table->text('requirement');
            $table->string('express_delivery_time');
            $table->enum('gender',array(0,1,2,3));
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
        Schema::dropIfExists('products');

    }
}
