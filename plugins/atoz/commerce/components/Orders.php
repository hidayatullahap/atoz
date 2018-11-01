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
        $orderNumber = $this->createOrderNumber();
        $shippingCode = $this->createShippingCode();
        $price  = $data['price'];
        $type   = $data['type'];
        $total  = $this->getTotalPrice($price, $type);

        try{
            if($type == "normal"){
                $productId = Product::create([
                    'name'          => $data['name'],
                    'product_type'  => $type,
                    'description'   => $data['description'],
                    'price'         => $price,
                ])->id;
                $address = $data['address'];
            }elseif($type == "prepaid"){
                $productId      = NULL;
                $address        = NULL;
                $shippingCode   = NULL;
            }else{
                throw new ApplicationException("Type did not exist");
            }
            
            Order::create([
                'user_id'           => Auth::getUser()->id,
                'product_id'        => $productId,
                'product_type'      => $type,
                'order_number'      => $orderNumber,
                'status_code'       => 'seen',
                'sum'               => $price,
                'total'             => $total,
                'shipping_address'  => $address,
                'shipping_code'     => $shippingCode,
                'expired_at'        => Carbon::now()->addMinutes(5),
            ]);
            
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

    public function createOrderNumber()
    {
        return mt_rand(00000000000, 9999999999);
    }

    public function createShippingCode()
    {
        return strtoupper(substr(md5(microtime()),rand(0,26),8));
    }
    
    public function getTotalPrice($price, $type)
    {
        if($type == "normal"){
            $total = $price + 10000;
        }elseif($type == "prepaid"){
            $total = $price * 1.05;
        }else{
            throw new ApplicationException("Type did not exist");
        }
        return $total;
    }
}
