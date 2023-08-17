<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Device;
use DB;

class BrandsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Get all devices in brand
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBrandDevices($id)
    {
        $devices = Device::where('brand_id', '=', $id)->orderBy('name')->get();

        foreach ($devices as $device) {
            $device->media = $device->multimedia()->get();
            //Seller ETB = 2
            $device->inventory = $device->inventory()->where('seller_id', '=', 2)->first();
        }

        return response()->json(['success' => true, 'data' => $devices]);
    }

    /**
     * Get all devices names in brand
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBrandDevicesNames($id)
    {
        $devices = DB::select('SELECT id, name FROM devices WHERE brand_id = :id ORDER BY name',
                              ['id' => $id]);

        return response()->json(['success' => true, 'data' => $devices]);
    }
}