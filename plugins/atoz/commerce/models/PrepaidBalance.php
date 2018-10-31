<?php namespace Atoz\Commerce\Models;

use Model;

/**
 * PrepaidBalance Model
 */
class PrepaidBalance extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'atoz_commerce_prepaid_balances';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

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
