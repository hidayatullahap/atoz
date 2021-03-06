<?php namespace Atoz\Commerce\Components;

use Cms\Classes\ComponentBase;
use Input, Request, Redirect, Flash, Auth, ApplicationException;
use Carbon\Carbon;
use Atoz\Commerce\Models\{Product, Order, OrderStatusLog};
use Atoz\Commerce\Classes\OrderHelper;
class Orders extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Orders Manager',
            'description' => 'Atoz Orders Manager'
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
        $currentUrl = request()->segment(1);
        if($currentUrl == 'order-finish'){
            $this->onFinishOrder();
        }elseif($currentUrl == "order"){
            $search = request('search');
            $this->page['search'] = $search;
            $this->page['orders'] = $this->getOrders();
        }
    }

    public function onAddOrder()
    {
        // dd(post());
        $data = post();
        $price  = $data['price'];
        $type   = $data['type'];

        try{
            if($type == "normal"){
                $productId = Product::create([
                    'name'          => $data['name'],
                    'product_type'  => $type,
                    'description'   => $data['description'],
                    'price'         => $price,
                ])->id;
                $address = $data['address'];
                $phoneNumber = NULL;
            }elseif($type == "prepaid"){
                $productId      = NULL;
                $address        = NULL;
                $phoneNumber    = $data['phone'];
            }else{
                throw new ApplicationException("Type did not exist");
            }
            
            $orderNumber = Order::create([
                'user_id'           => Auth::getUser()->id,
                'product_id'        => $productId,
                'product_type'      => $type,
                'phone_number'      => $phoneNumber,
                'status_code'       => 'seen',
                'sum'               => $price,
                'shipping_address'  => $address,
                'expired_at'        => Carbon::now()->addMinutes(5),
            ])->order_number;
            
            OrderStatusLog::create([
                'status_code'  => 'seen',
                'order_number' => $orderNumber,
            ]);

            Flash::success("Order recorded");
            return Redirect::to('/order-finish/'.$orderNumber);

        }catch (Exception $ex){
            Db::rollBack();
            throw $ex;
        }
    }

    public function getOrders()
    {
        return Order::where('user_id', Auth::getUser()->id)->where('order_number','like','%'.request('search').'%')->orderBy('created_at','desc')->paginate(20);
    }

    public function onFinishOrder()
    {
        $orderNumber = $this->property('order_number');

        if($orderNumber){
            $this->page['order'] = Order::where('order_number',$orderNumber)->first();
        }else{
            $this->page['order'] = NULL;
        }
    }
}
