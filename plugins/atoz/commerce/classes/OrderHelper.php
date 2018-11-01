<?php namespace Atoz\Commerce\Classes;

class OrderHelper
{
    public static function generateOrderNumber() {
        return mt_rand(00000000000, 9999999999);
    }

    public static function createShippingCode()
    {
        return strtoupper(substr(md5(microtime()),rand(0,26),8));
    }

}
