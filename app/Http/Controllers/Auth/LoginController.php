<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the ETB login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin($redirect = 'none')
    {
        return view('frontpages.login')->with(['redirect' => $redirect]);
    }

    /**
     * Handle a login  and redirect based on view navigate value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        if (!$request->has('order')) {
            $this->redirectTo = '/';
        } else {
            $order = $request->input('order');
            if ($request->has('payment_type')) {
                $this->redirectTo = '/usuario/contraentrega/'.$order;
            } else {
                $this->redirectTo = '/usuario/checkout/'.$order;
            }
        }

        return $this->login($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return response()->json([
            'success' => true,
            'data' => $this->redirectTo
        ]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'success' => false,
            'err' =>  Lang::get('auth.failed')
        ]);
    }

    /**
     * Get the custom guard used by the controller.
     *
     * @return string
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }
}
