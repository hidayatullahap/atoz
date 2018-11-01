<?php namespace Atoz\User\Models;

use Model;

/**
 * user Model
 */
class User extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'users';

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
    public $hasMany = [
        'orders' => [
            'Atoz\Commerce\Models\Order',
            'key'       => 'user_id',
            'otherKey'  => 'id',
        ],
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
