<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('desc');
            $table->string('address');
            $table->string('pic');
            $table->string('favicon');
            $table->string('video');
            $table->string('policy');
            $table->string('phone');
            $table->string('email');
            $table->float('lat',13,2);
            $table->float('long',13,2);
            $table->enum('lang',array('ar','en'));
            $table->string('app_store');
            $table->string('play_store');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('google');
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
        Schema::dropIfExists('info');
    }
}