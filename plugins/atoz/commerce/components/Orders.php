<?php namespace Atoz\Commerce\Components;

use Cms\Classes\ComponentBase;
use Atoz\Commerce\Models\{Product, Order, OrderStatusLog};
use Input, Redirect, Flash, Auth, ApplicationException;
use Carbon\Carbon;

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
        return [];
    }

    public function onAddOrder()
    {
        // dd(post());
        $data = post();
        $shippingCode = $this->createShippingCode();
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
                $shippingCode   = NULL;
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
                'shipping_code'     => $shippingCode,
                'expired_at'        => Carbon::now()->addMinutes(5),
            ])->order_number;
            
            OrderStatusLog::create([
                'status_code'  => 'seen',
                'order_number' => $orderNumber,
            ]);

            Flash::success("Order berhasil dimasukan");
            return Redirect::refresh();

        }catch (Exception $ex){
            Db::rollBack();
            throw $ex;
        }
    }

    public function createShippingCode()
    {
        return strtoupper(substr(md5(microtime()),rand(0,26),8));
    }

    public function getOrders()
    {
        return Order::where('user_id', Auth::getUser()->id)->get()->sortByDesc('created_at');
    }
}
