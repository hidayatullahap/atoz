<?php namespace Atoz\Commerce\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrderStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('atoz_commerce_order_statuses', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atoz_commerce_order_statuses');
    }
}
