<?php namespace Atoz\Commerce\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Input, Redirect, Flash, Auth;
use Atoz\Commerce\Classes\PaymentHelper;
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
                if(!$this->checkOrderBelongToUser($order->user_id)) throw new \ApplicationException("Order number is not belong to you");
                if($order->expired_at < Carbon::now()->format('Y-m-d H:i:s')) throw new \ApplicationException("Order has beed expired please create new order");
                $status = $order->log_statuses->last();
                $status ? $status = $status->status_code : $status = NULL;
                if($status == "seen"){
                    $isSuccess = PaymentHelper::determinePaymentStatus();
                    if($order->product_type == "normal") $isSuccess = TRUE;
                    $order->status_code = "paid";
                    $order->save();
                    
                    OrderStatusLog::create([
                        'status_code'   => 'paid',
                        'order_number'  => $order->order_number,
                        'isSucceed'     => $isSuccess,
                    ]);

                    if($isSuccess){
                        Flash::success("Payment with order number ".$order->order_number ." is success!");
                    }else{
                        Flash::error("Payment with order number ".$order->order_number ." paid, but failed to fill the balance");
                    }

                    return Redirect::to("/order");
                }elseif($status == "paid"){
                    Flash::error('Order has been paid');
                }elseif($status == "canceled"){
                    Flash::error('Order has been canceled');
                }else{
                    throw new \Exception("Status type is not found");
                }
            }else{
                Flash::error('Order number is not found');
            }
        }else{
            Flash::error('Please insert order number');
        }
    }

    public function checkOrderBelongToUser($orderUserId){
        if(Auth::getUser()->id == $orderUserId) return TRUE;
        return FALSE;
    }
}
