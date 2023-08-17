<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sellers';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the inventory associated with the seller.
     */
    public function inventory()
    {
        return $this->hasMany('App\Models\Inventory');
    }

    /**
     * The customers that belong to the seller.
     */
    public function customers()
    {
        return $this->belongsToMany('App\Models\Customer', 'customer_seller');
    }
}
