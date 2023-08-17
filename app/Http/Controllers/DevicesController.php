<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Device;

class DevicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Get device details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeviceDetails($id)
    {
        $device = Device::find($id);
        //Seller ETB = 2
        $device->inventory = $device->inventory()->where('seller_id', '=', 2)->first();
        $device->media = $device->multimedia()->get();

        return response()->json(['success' => true, 'data' => $device]);
    }
}