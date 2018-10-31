<?php namespace Atoz\Commerce\Updates;

use October\Rain\Database\Updates\Seeder;
use Atoz\Commerce\Models\OrderStatus;

class SeedOrderStatuses extends Seeder
{

    public function run()
    {
        OrderStatus::create([
            'name' => 'Paid',
            'code'=>'paid',
            'description'=>'Order is paid and ready to be packed.',
        ]);

        OrderStatus::create([
            'name' => 'Canceled',
            'code'=>'canceled',
            'description'=>'Order is canceled.',
        ]);

        OrderStatus::create([
            'name' => 'Seen',
            'code'=>'seen',
            'description'=>'Order created',
        ]);
    }

}