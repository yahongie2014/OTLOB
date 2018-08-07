<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_notifications', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('user_category', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('category')->onDelete('cascade');
        });
        Schema::table('roles', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('product_image', function(Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('product_exeption_date', function(Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('product_availibility', function(Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('products', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('category')->onDelete('cascade');
        });
        Schema::table('payment', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('order_product', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('area')->onDelete('cascade');
            $table->foreign('promo_code_id')->references('id')->on('promo_code')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('bank_account')->onDelete('cascade');
        });
        Schema::table('order_items', function(Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('order_product')->onDelete('cascade');
        });
        Schema::table('notifications', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('feed_back', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('prod_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('order_product')->onDelete('cascade');
        });
        Schema::table('country', function(Blueprint $table){
            $table->foreign('area_id')->references('id')->on('area')->onDelete('cascade');
        });
        Schema::table('cities', function(Blueprint $table){
            $table->foreign('nation_id')->references('id')->on('nations')->onDelete('cascade');
        });
        Schema::table('carts', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('availibility', function(Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('area', function(Blueprint $table){
            $table->foreign('currency_id')->references('id')->on('currency')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_notifications', function(Blueprint $table){
            $table->dropForeign('web_user_id_foreign');
        });
        Schema::table('user_category', function(Blueprint $table){
            $table->dropForeign('category_user_id_foreign');
            $table->dropForeign('category_cat_id_foreign');
        });
        Schema::table('roles', function(Blueprint $table){
            $table->dropForeign('roles_user_id_foreign');
            $table->dropForeign('roles_vendor_id_foreign');
        });
        Schema::table('product_image', function(Blueprint $table){
            $table->dropForeign('image_product_id_foreign');
        });
        Schema::table('product_exeption_date', function(Blueprint $table){
            $table->dropForeign('exeption_date_product_id_foreign');
        });
        Schema::table('product_availibility', function(Blueprint $table){
            $table->dropForeign('availibility_product_id_foreign');
        });
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign('products_user_id_foreign');
            $table->dropForeign('products_cat_id_foreign');
        });
        Schema::table('payment', function(Blueprint $table){
            $table->dropForeign('payment_user_id_foreign');
        });
        Schema::table('order_product', function(Blueprint $table){
            $table->dropForeign('order_product_user_id_foreign');
            $table->dropForeign('order_area_id_foreign');
            $table->dropForeign('order_promo_code_id_foreign');
            $table->dropForeign('order_bank_id_foreign');
        });
        Schema::table('order_items', function(Blueprint $table){
            $table->dropForeign('items_product_id_foreign');
            $table->dropForeign('items_order_id_foreign');
        });
        Schema::table('notifications', function(Blueprint $table){
            $table->dropForeign('notifications_user_id_foreign');
        });
        Schema::table('feed_back', function(Blueprint $table){
            $table->dropForeign('feed_back_user_id_foreign');
            $table->dropForeign('feed_back_prod_id_foreign');
            $table->dropForeign('feed_back_order_id_foreign');
        });
        Schema::table('country', function(Blueprint $table){
            $table->dropForeign('country_area_id_foreign');
        });
        Schema::table('cities', function(Blueprint $table){
            $table->dropForeign('cities_nation_id_foreign');
        });
        Schema::table('carts', function(Blueprint $table){
            $table->dropForeign('carts_user_id_foreign');
            $table->dropForeign('carts_product_id_foreign');
        });
        Schema::table('availibility', function(Blueprint $table){
            $table->dropForeign('availibility_product_id_foreign');
        });
        Schema::table('area', function(Blueprint $table){
            $table->dropForeign('area_currency_id_foreign');
        });
    }
}
