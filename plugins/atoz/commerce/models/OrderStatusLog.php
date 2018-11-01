<?php namespace Atoz\Commerce\Models;

use Model;

/**
 * OrderStatusLog Model
 */
class OrderStatusLog extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'atoz_commerce_order_status_logs';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'status_code',
        'order_number',
        'isSucceed',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
