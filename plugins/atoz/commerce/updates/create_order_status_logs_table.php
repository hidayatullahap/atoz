<?php namespace Atoz\Commerce\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrderStatusLogsTable extends Migration
{
    public function up()
    {
        Schema::create('atoz_commerce_order_status_logs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('status_code');
            $table->string('order_number');
            $table->boolean('isSucceed')->nullable()->default(TRUE);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atoz_commerce_order_status_logs');
    }
}
