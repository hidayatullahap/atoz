<?php namespace Atoz\Commerce\Classes;

class OrderHelper
{
    public static function generateOrderNumber() {
        $returnString = mt_rand(1, 9);
        while (strlen($returnString) < 10) {
            $returnString .= mt_rand(0, 9);
        }
        return $returnString;
    }

    public static function createShippingCode()
    {
        return strtoupper(substr(md5(microtime()),rand(0,26),8));
    }

}
