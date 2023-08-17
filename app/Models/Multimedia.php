<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'multimedia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name', 'file_type', 'original_name', 'src', 'is_main', 'device_id'
    ];

    /**
     * Get the device that owns the comment.
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }
}