<?php

namespace App\Http\Controllers;

use Alexo\LaravelPayU\LaravelPayU;
use App\Models\City;
use App\Models\Device;
use App\Models\Order;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class PaymentsController extends Controller
{
    /**
     *
     * @var array
     */
    private $banks;
    /**
     *
     * @var string
     */
    private $refCode;
    /**
     *
     * @var array
     */
    private $response;
    /**
     *
     * @var bool
     */
    private $success;

    private $messages = [
        'required' => 'El campo :attribute es requerido',
        'user_imei.integer' => 'El imei debe ser un máximo de 15 números',
        'payment_method.in_array' => 'El metodo de pago no es válido.',
        'expiration_date.date_format' => 'La fecha de expiración debe tener el formato: año/mes',
        'payer_email' => 'El correo del titular de la tarjeta no es válido',
        'payer_phone.integer' => 'El teléfono del pagador debe ser un número de máximo 10 dígitos'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the checkout etb page
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout($ref)
    {
        $order = Order::where('reference', '=', $ref)->first();

        if (count($order) > 0) {
            $order->customer_id = Auth::guard('customer')->user()->id;
            $order->save();

            LaravelPayU::getPSEBanks(function($banks) {
                $this->banks = $banks;
            }, function($error) {
                $this->banks = [];
                Log::error('Exception getting banks:', get_object_vars($error));
            });

            $city = City::find($order->city_id);
            setlocale(LC_TIME, 'Spanish');
            $date = Carbon::parse($order->delivery_date);
            $order->delivery_date = $date->toFormattedDateString();
            $order->value = '$'.number_format($order->value);
            $order->city = $city->name;

            $arrayPlan = explode(":", $order->plan);
            $plan['name'] = $arrayPlan[0];
            $plan['price'] = '$'.number_format($arrayPlan[1]);

            $new = Device::find($order->device_new_id);
            $new->inventory = $new->inventory()->where('seller_id', '=', 2)->first();

            if ($plan['name'] == 'ETB Prepago') {
                if ($order->device_new_state == 2) {
                    $new->price = '$'.number_format($new->inventory['sell_affordable'] + 10000);
                } else {
                    $new->price = '$'.number_format($new->inventory['sell_new']);
                }
            } else {
                if ($order->device_new_state == 2) {
                    $new->price = '$'.number_format($new->inventory['sell_affordable']);
                } else {
                    $new->price = '$'.number_format($new->inventory['sell_plan']);
                }
            }

            $used = Device::find($order->device_used_id);
            $used->inventory = $used->inventory()->where('seller_id', '=', 2)->first();
            $used->price = '$'.number_format($used->inventory[
                OrdersController::getDeviceState($order->device_used_state)
            ]);

            return view('frontpages.checkout')->with([
                'order'=> $order,
                'plan' => $plan,
                'new' => $new,
                'used' => $used,
                'banks' => $this->banks
            ]);
        } else {
            return redirect('/');
        }
    }

    public function processPayURequest(Request $req)
    {
        //Validate payment data
        $validator = Validator::make($req->all(), [
            'user_imei' => 'required|integer',
            'payment_type' => 'required|string',
            'expiration_date' => 'date_format:Y/m',
            'payer_email' => 'email',
            'payer_phone' => 'integer'
        ], $this->messages);

        if ($validator->fails()) {
            $response["message"] = $validator->errors()->all();
            return response()->json(['success' => false, 'data' => $response]);
        } else {
            $order = Order::where('reference', '=', $req->input('order'))->first();

            if (count($order) > 0) {
                $order->customer_id = Auth::guard('customer')->user()->id;
                $order->save();

                $this->refCode = $req->input('order');
                //Estado sin procesar
                if ($order->state == 1) {
                    if ($req->input('payment_type') == 'credit_card') {
                        $order->imei = $req->input('user_imei');
                        $order->payment_type = 1;
                        $order->save();
                        return $this->processCreditCard($req->all(), $order);
                    }

                    if ($req->input('payment_type') == 'baloto_efecty') {
                        $order->imei = $req->input('user_imei');
                        $order->payment_type = 2;
                        $order->save();
                        return $this->processEfectyBaloto($req->all(), $order);
                    }

                    if ($req->input('payment_type') == 'pse') {
                        $order->imei = $req->input('user_imei');
                        $order->payment_type = 3;
                        $order->save();
                        return $this->processPSE($req->all(), $order);
                    }
                } else {
                    $response["message"] = 'La orden ya fué procesada anteriormente.';
                    return response()->json(['success' => false, 'data' => $response]);
                }
            } else {
                $response["message"] = 'No se puede procesar la order ingresada';
                return response()->json(['success' => false, 'data' => $response]);
            }
        }
    }

    /**
     * Process the result of bank processing (PSE)
     *
     * @return \Illuminate\Http\Response
     */
    public function processResultPSE(Request $request)
    {
        $ref = $request->input('referenceCode');
        $order = Order::where('reference', '=', $ref)->first();

        if (count($order) > 0) {
            $order->transaction_response = json_encode($request->all());
            $order->save();
            return redirect('usuario/show-result/'.$order->reference);
        }
    }

    /**
     * Show the result of bank processing (PSE)
     *
     * @return \Illuminate\Http\Response
     */
    public function showResultPSE($refCode)
    {
        $order = Order::where('reference', '=', $refCode)->first();

        if (count($order) > 0) {
            $res = json_decode($order->transaction_response);
            $customer = Auth::guard('customer')->user()->name;
            $dni = Auth::guard('customer')->user()->identification;
            $transState = $this->getStateTextFromCode($res->polTransactionState);
            $transResponse = $this->getDescTextFromCode($res->polResponseCode);
            $orderDate = Carbon::parse($order->updated_at);
            $order->date = $orderDate->toDayDateTimeString();

            return view('frontpages.result-pse')->with(
                compact('order', 'res', 'transState', 'transResponse', 'customer', 'dni')
            );
        }
    }

    public function finishPSE($refCode, $state)
    {
        $order = Order::where('reference', '=', $refCode)->first();

        if (count($order) > 0) {
            if ($state == 'Aprobada') {
                $order->state = 2;
                $order->save();
                OrdersController::updateDeviceStock($order);

                return redirect('usuario/dashboard/approved');
            }

            if ($state == 'Pendiente') {
                $order->state = 4;
                $order->save();

                return redirect('usuario/dashboard/pending');
            }

            $order->state = 3;
            $order->save();

            return redirect('usuario/dashboard/declined');
        } else {
            return redirect('usuario/dashboard');
        }
    }

    /**
     * Process credit card payment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function processCreditCard($data, $order)
    {
        $parameters = array(
            \PayUParameters::INSTALLMENTS_NUMBER => $data['installments'],
            \PayUParameters::COUNTRY => \PayUCountries::CO,
            \PayUParameters::PAYER_COOKIE => 'cookie_' . time(),
            \PayUParameters::CURRENCY => 'COP',
            \PayUParameters::REFERENCE_CODE => $this->refCode,
            \PayUParameters::DESCRIPTION => 'ETB Te lo cambio pago online con tarjeta de crédito',
            \PayUParameters::VALUE => $order->value,
            \PayUParameters::PAYER_ID => Auth::guard('customer')->user()->id,
            \PayUParameters::PAYER_NAME => $data['payer_name'],
            \PayUParameters::PAYER_EMAIL => $data['payer_email'],
            \PayUParameters::PAYER_CONTACT_PHONE => $data['payer_phone'],
            \PayUParameters::CREDIT_CARD_NUMBER => $data['card_number'],
            \PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $data['expiration_date'],
            \PayUParameters::CREDIT_CARD_SECURITY_CODE => $data['card_cvc'],
            \PayUParameters::PROCESS_WITHOUT_CVV2 => false,
            \PayUParameters::PAYMENT_METHOD => $data['payment_method']
        );

        $order->payWith($parameters, function($response, $order) {
            if ($response->code == 'SUCCESS') {
                $order->transaction_response = json_encode($response->transactionResponse);

                if ($response->transactionResponse->state == 'APPROVED') {
                    //Aprobado
                    $order->state = 2;
                    $order->save();
                    $this->success = true;
                    OrdersController::updateDeviceStock($order);

                    $this->response['redirect'] = '/usuario/dashboard/approved';
                }

                if ($response->transactionResponse->state == 'DECLINED') {
                    //Rechazado
                    $order->state = 3;
                    $order->save();
                    $this->success = true;

                    $this->response['redirect'] = '/usuario/dashboard/declined';
                }

                if ($response->transactionResponse->state == 'PENDING') {
                    //Pendiente
                    $order->state = 4;
                    $order->save();
                    $this->success = true;
                    $this->response['redirect'] = '/usuario/dashboard/pending';
                }

                OrdersController::sendSellConfirmationMail($order);
            } else {
                $order->state = 5;
                $order->save();
                $this->response['status'] = 'error';
                $this->response['message'] = 'Ha fallado la solicitud de pago. '.
                                           'Intente una nueva orden.';
            }
        }, function($error) {
            $this->response['status'] = 'error';
            $this->response['message'] = $error->getMessage();
        });

        return response()->json([
            'success' => $this->success,
            'data' => $this->response
        ]);
    }

    /**
     * Process baloto efecty payment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function processEfectyBaloto($data, $order)
    {
        $now = Carbon::now();
        $nextWeek = $now->addDays(8);
        $parameters = array(
            \PayUParameters::REFERENCE_CODE => $this->refCode,
            \PayUParameters::DESCRIPTION => "ETB Te lo cambio pago online en efectivo",
            \PayUParameters::CURRENCY => "COP",
            \PayUParameters::VALUE => $order->value,
            \PayUParameters::PAYER_NAME => Auth::guard('customer')->user()->name,
            \PayUParameters::PAYER_DNI => Auth::guard('customer')->user()->identification,
            \PayUParameters::PAYMENT_METHOD => $data['payment_method'],
            \PayUParameters::EXPIRATION_DATE => $nextWeek->format('Y-m-d\TH:i:s')
        );

        $order->payWith($parameters, function($response, $order) {
            if ($response->code == 'SUCCESS') {
                $order->transaction_response = json_encode($response->transactionResponse);

                if ($response->transactionResponse->state == 'DECLINED') {
                    //Rechazado
                    $order->state = 3;
                    $order->save();
                    $this->success = true;

                    $this->response['redirect'] = '/usuario/dashboard/declined';
                }

                if ($response->transactionResponse->state == 'PENDING') {
                    //Pendiente
                    $order->state = 4;
                    $order->save();
                    $this->success = true;
                    $this->response['redirect'] = '/usuario/dashboard/pending';
                }
            } else {
                $order->state = 5;
                $order->save();
                $this->response['status'] = 'error';
                $this->response['message'] = 'Ha fallado la solicitud de pago. '.
                                           'Intente una nueva orden.';
            }
            OrdersController::sendSellConfirmationMail($order);
        }, function($error) {
            $this->response['status'] = 'error';
            $this->response['message'] = $error->getMessage();
        });

        return response()->json([
            'success' => $this->success,
            'data' => $this->response
        ]);
    }

    /**
     * Process PSE payment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function processPSE($data, $order)
    {
        $parameters = array(
            \PayUParameters::REFERENCE_CODE => $this->refCode,
            \PayUParameters::DESCRIPTION => "ETB Te lo cambio pago online PSE",
            \PayUParameters::CURRENCY => "COP",
            \PayUParameters::VALUE => $order->value,
            \PayUParameters::PAYMENT_METHOD => $data['payment_method'],
            \PayUParameters::COUNTRY => \PayUCountries::CO,
            \PayUParameters::PAYER_NAME => $data['payer_name_account'],
            \PayUParameters::PAYER_CONTACT_PHONE => $data['payer_pse_phone'],
            \PayUParameters::PAYER_EMAIL => Auth::guard('customer')->user()->email,
            \PayUParameters::PAYER_DOCUMENT_TYPE => $data['payer_document_type'],
            \PayUParameters::PAYER_DNI => $data['payer_dni'],
            \PayUParameters::PSE_FINANCIAL_INSTITUTION_CODE => $data['bank'],
            \PayUParameters::PAYER_PERSON_TYPE => $data['payer_person_type'],
            \PayUParameters::PAYER_DOCUMENT_TYPE => $data['payer_document_type'],
            \PayUParameters::PAYER_COOKIE => "cookie_" . time(),
            \PayUParameters::IP_ADDRESS => $_SERVER['REMOTE_ADDR'],
            \PayUParameters::USER_AGENT => $_SERVER['HTTP_USER_AGENT'],
            \PayUParameters::RESPONSE_URL => "http://localhost:3000/usuario/process-result" //"http://etbtelocambio.co/usuario/process-result" 
        );

        $order->payWith($parameters, function($response, $order) {
            if ($response->code == 'SUCCESS') {
                $order->transaction_response = json_encode($response->transactionResponse);

                if ($response->transactionResponse->state == 'DECLINED') {
                    //Rechazado
                    $order->state = 3;
                    $order->save();
                    $this->success = true;

                    $this->response['redirect'] = '/usuario/dashboard/declined';
                }

                if ($response->transactionResponse->state == 'PENDING') {
                    //Pendiente
                    $order->state = 4;
                    $order->save();
                    $this->success = true;
                    $this->response['redirect'] = $response->transactionResponse->extraParameters->BANK_URL;
                }
            } else {
                $order->state = 5;
                $order->save();
                $this->response['status'] = 'error';
                $this->response['message'] = 'Ha fallado la solicitud de pago. '.
                                           'Intente una nueva orden.';
            }
            OrdersController::sendSellConfirmationMail($order);
        }, function($error) {
            $this->response['status'] = 'error';
            $this->response['message'] = $error->getMessage();
        });

        return response()->json([
            'success' => $this->success,
            'data' => $this->response
        ]);
    }

    /**
     * Return state text based on codes
     * http://developers.payulatam.com/es/web_checkout/variables.html
     * @return String
     */
    private function getStateTextFromCode($code)
    {
        switch($code) {
        case 4 :
            return 'Aprobada';
            break;
        case 5 :
            return 'Expirada';
            break;
        case 6 :
            return 'Rechazada';
            break;
        case 7 :
            return 'Pendiente';
            break;
        case 10 :
            return 'Pendiente';
            break;
        case 12 :
            return 'Pendiente';
            break;
        case 14 :
            return 'Pendiente';
            break;
        case 15 :
            return 'Pendiente';
            break;
        case 18 :
            return 'Pendiente';
            break;
        }
    }

    /**
     * Return state text based on codes
     * http://developers.payulatam.com/es/web_checkout/variables.html
     * @return String
     */
    private function getDescTextFromCode($code)
    {
        switch($code) {
        case 1 :
            return 'Transacción aprobada';
            break;
        case 4 :
            return 'Transacción rechazada por entidad financiera';
            break;
        case 5 :
            return 'Transacción rechazada por el banco';
            break;
        case 6 :
            return 'Fondos insuficientes';
            break;
        case 7 :
            return 'Tarjeta inválida';
            break;
        case 8 :
            return 'Débito automático no permitido. Contactar entidad financiera';
            break;
        case 9 :
            return 'Tarjeta vencida';
            break;
        case 10 :
            return 'Tarjeta restringida';
            break;
        case 12 :
            return 'Fecha de expiración o código de seguridad inválidos';
            break;
        case 13 :
            return 'Reintentar pago';
            break;
        case 14 :
            return 'Transacción inválida';
            break;
        case 15 :
            return 'Transacción en validación manual';
            break;
        case 17 :
            return 'El valor excede el máximo permitido por la entidad';
            break;
        case 19 :
            return 'Transacción abandonada por el pagador';
            break;
        case 20 :
            return 'Transacción expirada';
            break;
        case 22 :
            return 'Tarjeta no autorizada para comprar por internet';
            break;
        case 25 :
            return 'Recibo de pago generado. En espera de pago';
            break;
        case 26 :
            return 'Recibo de pago generado. En espera de pago';
            break;
        case 29 :
            return 'Pendiente en envío a la entidad financiera';
            break;
        case 9994 :
            return 'En espera de confirmación de PSE';
            break;
        case 9995 :
            return 'Certificado digital no encotnrado';
            break;
        case 9996 :
            return 'Error tratando de comunicarse con el banco';
            break;
        case 9997 :
            return 'Error comunicándose con la entidad financiera';
            break;
        case 9998 :
            return 'Transacción no permitida';
            break;
        case 9999 :
            return 'Error';
            break;
        }
    }

    private function extractNumbers($str)
    {
        return (int)preg_replace("/[^0-9]/", "", $str);
    }
}
