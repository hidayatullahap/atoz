<?php namespace Atoz\Commerce\Components;

use Cms\Classes\ComponentBase;

class Payments extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Payment Manager',
            'description' => 'Atoz Payment Manager'
        ];
    }

    public function defineProperties()
    {
        return [
            'order_number' => [
                'title'     => 'Order Number',
                'type'      => 'string',
                'default'   => '{{ :order_number }}',
            ]
        ];
    }

    public function onRun()
    {
        $this->page['order_number'] = $this->property('order_number');
    }
}
