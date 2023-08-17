<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'devices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference_id', 'name', 'system', 'network', 'camera', 'specifications',
        'conectivity', 'multimedia', 'messaging', 'others', 'brand_id'
    ];

    /**
     * Get the multimedia for the device.
     */
    public function multimedia()
    {
        return $this->hasMany('App\Models\Multimedia');
    }

    /**
     * Get the inventory associated with the device.
     */
    public function inventory()
    {
        return $this->hasMany('App\Models\Inventory');
    }
}
