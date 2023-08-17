<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Customer;
use App\Models\Seller;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/usuario/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the user registration celucambio form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSignup()
    {
        $cities = City::all();
        return view('frontpages.signup', [
            'cities' => $cities
        ]);
    }

    /**
     * Create customer for Celucambio
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $req)
    {
        $seller = Seller::find(1);

        $validator = Validator::make($req->all(), [
            'name' => 'required|max:90',
            'email' => 'required|unique:customers|email',
            'password' => 'required|min:8',
            'identification' => 'required|integer',
            'identification_type' => 'required|numeric',
            'phone' => 'required|digits_between:7,10',
            'password' => 'required',
            'navigate' => 'string',
            'step' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()->all()]);
        }

        $customer = Customer::create([
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'password' => $req->input('password'),
            'seller_id' => $seller->id,
            'identification' => $req->input('identification'),
            'identification_type' => $req->input('identification_type'),
            'phone' => $req->input('phone'),
            'address' => $req->input('address')
        ]);

        $customer->sellers()->save($seller);

        //Authenticate before redirect url
        if (Auth::guard('customer')->attempt([
            'email' => $customer->email,
            'password' => $req->input('password')
        ])) {
            if ($req->has('order')) {
                if ($req->has('payment_type')) {
                    return response()->json([
                        'success' => true,
                        'data' => '/usuario/contraentrega/'.$req->input('order')
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'data' => '/usuario/checkout/'.$req->input('order')
                    ]);
                }
            } else {
                return response()->json(['success' => true, 'data' => '/']);
            }
        } else {
            return response()->json(['success' => false, 'data' => ['No se encontró el usuario.']]);
        }
    }
}
