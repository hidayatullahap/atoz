<?php namespace Atoz\Commerce\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('atoz_commerce_orders', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('user_id');
            $table->string('product_id')->nullable();
            $table->string('product_type');
            $table->string('order_number');
            $table->string('status_code');
            $table->string('phone_number')->nullable();
            $table->integer('sum')->nullable()->unsigned();
            $table->integer('total')->nullable()->unsigned();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_code')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atoz_commerce_orders');
    }
}
