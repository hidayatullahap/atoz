<?php namespace Atoz\Commerce\Classes;

use Carbon\Carbon;

class PaymentHelper
{
    /**
     * If the paid time happened in the daylight (9AM to 5PM) 
     * there is 90% success rate for inserting the balance, 
     * 40% otherwise.
     */
    public static function determinePaymentStatus() 
    {
        $start = '09:00:00';
        $end   = '17:00:00';
        $now   = Carbon::now();
        $time  = $now->format('H:i:s');

        if ($time >= $start && $time <= $end) {
            return (new self)->rollDice(90);
        }else{
            return (new self)->rollDice(0);
        }
    }

    public function rollDice($percentage)
    {
        $p = rand(0,100);
        if ($p <= $percentage){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
