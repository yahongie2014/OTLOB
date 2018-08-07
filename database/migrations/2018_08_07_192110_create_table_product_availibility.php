<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableProductAvailibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_availibility', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->index()->unsigned();
            $table->integer('day_no');
            $table->integer('gender');
            $table->integer('quantity');
            $table->integer('period');
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
        Schema::dropIfExists('product_availibility');

    }
}
