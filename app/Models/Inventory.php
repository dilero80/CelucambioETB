<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventories';

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
        'sell_new', 'sell_affordable', 'sell_plan', 'receive_defective', 'receive_aceptable', 'receive_good',
        'receive_excelent', 'stock_new', 'stock_used', 'device_id', 'seller_id'
    ];

    /**
     * Get the device owns the price.
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }

    /**
     * Get the seller owns the price.
     */
    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }
}
