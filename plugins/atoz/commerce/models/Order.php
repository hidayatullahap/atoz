<?php namespace Atoz\Commerce\Models;

use Model, ApplicationException;
use Atoz\Commerce\Classes\OrderHelper;

/**
 * Order Model
 */
class Order extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'atoz_commerce_orders';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'product_type',
        'order_number',
        'phone_number',
        'status_code',
        'sum',
        'total',
        'shipping_address',
        'shipping_code',
        'expired_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'log_statuses' => [
            'Atoz\Commerce\Models\OrderStatusLog',
            'key'       => 'order_number',
            'otherKey'  => 'order_number',
        ],
    ];
    public $belongsTo = [
        'product' => [
            'Atoz\Commerce\Models\Product',
            'key'       => 'product_id',
            'otherKey'  => 'id',
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $this->total = $this->getTotalPrice($this->sum, $this->product_type);
        $this->order_number = OrderHelper::generateOrderNumber();
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
