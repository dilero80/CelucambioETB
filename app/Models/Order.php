<?php

namespace App\Models;

use Alexo\LaravelPayU\Payable;
use Alexo\LaravelPayU\Searchable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Payable, Searchable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'reference', 'transaction_response', 'payment_type', 'state', 'customer_id', 'imei',
        'device_used_id', 'device_new_id', 'device_used_state', 'device_new_state', 'delivery_address',
        'delivery_time', 'delivery_date', 'plan', 'seller_id', 'operator_id', 'city_id'
    ];

    /**
     * Get the customer owns the order.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
