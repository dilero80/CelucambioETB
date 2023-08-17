<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\City;
use App\Http\Requests;

class FrontPagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the home frontpage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        $brands = Brand::all();

        return view('frontpages.exchange', [
            'brands' => $brands,
            'cities' => $cities]);
    }
}