<?php

namespace App\Models;

use App\Notifications\CustomerResetPassword;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'identification_type', 'identification', 'phone',
        'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($pass) {
		$this->attributes['password'] = Hash::make($pass);
	}

    /**
     * The sellers that belong to the customer.
     */
    public function sellers()
    {
        return $this->belongsToMany('App\Models\Seller', 'customer_seller');
    }

    /**
     * The orders that belong to the customer.
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPassword($token));
    }
}
