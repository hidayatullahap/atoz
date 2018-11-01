<?php namespace Atoz\Commerce\Components;

use Cms\Classes\ComponentBase;
use Input, Redirect, Flash;
use Atoz\Commerce\Models\{Order, OrderStatusLog};
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
    
    public function onPayProduct()
    {
        if(!empty(Input::get('order_number'))){
            $order_number = Input::get('order_number');
            $order = Order::where('order_number', $order_number)->first();
            if($order){
                $status = $order->log_statuses->last();
                $status ? $status = $status->status_code : $status = NULL;
                if($status == "seen"){

                }elseif($status == "paid"){
                    Flash::error('Order has been paid');
                }elseif($status == "canceled"){
                    Flash::error('Order has been canceled');
                }else{
                    throw new ApplicationException("Status type is not found");
                }
            }else{
                Flash::error('Order number is not found');
            }
        }else{
            Flash::error('Please insert order number');
        }
    }
}
