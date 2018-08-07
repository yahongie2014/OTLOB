<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableDailyReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_report', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('all_users')->index();
            $table->integer('providers')->index();
            $table->integer('all_products')->index();
            $table->integer('waiting_products');
            $table->integer('active_products');
            $table->integer('deactivated_products');
            $table->integer('all_orders');
            $table->integer('completed_orders');
            $table->integer('rejected_orders');
            $table->integer('preparing_orders');
            $table->integer('waiting_orders');
            $table->integer('feed_back');
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
        Schema::dropIfExists('daily_report');
    }
}