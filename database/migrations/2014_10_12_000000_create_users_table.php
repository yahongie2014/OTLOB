<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name')->index();
            $table->string('pic');
            $table->string('email')->unique()->index();
            $table->string('password', 60);
            $table->string('phone')->unique()->index();
            $table->string('address');
            $table->string('v_code', 4);
            $table->integer('verified')->default(0);
            $table->integer('currency_id')->default(0);
            $table->integer('area_id')->default(0);
            $table->integer('is_vendor')->default(0);
            $table->integer('is_admin')->default(0);
            $table->integer('nation_id')->default(0);
            $table->integer('is_privillage')->default(0);
            $table->string('token');
            $table->string('country');
            $table->string('firebase_token');
            $table->float('charge_cost',13,2);
            $table->float('fees',13,2);
            $table->integer('blocked')->default(0);
            $table->integer('cat_id')->default(0);
            $table->integer('type')->default(0);
            $table->integer('attempts')->default(0);
            $table->integer('login_via_mobile')->default(0);
            $table->integer('login_via_dashboard')->default(0);
            $table->enum('login_by', array('manual', 'facebook', 'google'));
            $table->enum('device_type', array('android', 'ios','web'));
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
