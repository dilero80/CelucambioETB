<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\City;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class OrdersController extends Controller
{
    private $plans = [
        'ETB Prepago' => '0',
        'Call Pospago' => '30000',
        'Like Pospago' => '32000',
        'Mega Like Pospago' => '37000',
        'Selfie Pospago' => '43000',
        'Cool Pospago' => '55000',
        'Play Pospago' => '77000',
        'Extreme Pospago' => '120000',
        'Supreme Pospago' => '140000',
        'King Pospago' => '155000',
        'Call Control' => '30000',
        'Like Control' => '32000',
        'Mega Like Control' => '37000',
        'Selfie Control' => '43000',
        'Cool Control' => '55000',
        'Play Control' => '77000',
        'Extreme Control' => '120000',
        'Supreme Control' => '140000',
        'King Control' => '155000'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:customer', ['except' => ['createOrder']]);
    }

    /**
     * Create temp order to the user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $req)
    {
        $values['reference'] = uniqid(time());
        $values['state'] = 1;
        $values['device_used_id'] = $req->input('device_used_id');
        $values['device_used_state'] = $req->input('device_used_state');

        if ($req->has('device_new_id')) {
            $values['device_new_id'] = $req->input('device_new_id');
        }
        if ($req->has('device_new_state')) {
            $values['device_new_state'] = $req->input('device_new_state');
        }
        if ($req->has('payment_type')) {
            $values['payment_type'] = $req->input('payment_type');
        }
        $values['delivery_address'] = $req->input('delivery_address');
        $values['delivery_time'] = $req->input('delivery_time');
        $date = explode("/", $req->input('delivery_date'));
        $values['delivery_date'] = $date[2].'-'.$date[1].'-'.$date[0];
        $values['plan'] = $req->input('plan')['name'].':'.$this->plans[$req->input('plan')['name']];
        $values['city_id'] = $req->input('city_id');
        $values['seller_id'] = 2;
        $values['operator_id'] = 4;

        $order = Order::create($values);
        $values = self::getOrderValues($order);
        $order->value = $values['total'];
        $order->save();

        $response['order_ref'] = $order->reference;

        if (Auth::guard('customer')->check()) {
            $order->customer_id = Auth::guard('customer')->user()->id;
            $order->save();

            if ($order->payment_type == 4) {
                $response['redirect'] = '/usuario/contraentrega/'.$order->reference;
            } else {
                $response['redirect'] = '/usuario/checkout/'.$order->reference;
            }
        }else {
            $response['redirect'] = '/ingresar';
        }

        return response()->json(['success' => true, 'data' => $response]);
    }

    /**
     * Show the orders page
     *
     * @return \Illuminate\Http\Response
     */
    public function orders($transaction = 'none')
    {
        $customer = Auth::guard('customer')->user()->id;
        $orders = Order::where('customer_id', '=', $customer)->get();

        foreach($orders as $order) {
            $deviceUsed = Device::find($order->device_used_id);
            if (!is_null($order->device_new_id)) {
                $deviceNew = Device::find($order->device_new_id);
                $order->name = self::getStateOfNewETB($order->device_new_state)
                             .' '.$deviceNew->name.' a cambio de '.$deviceUsed->name;
            } else {
                $order->name = 'Venta de tu '. $deviceUsed->name;
            }
            $date = Carbon::parse($order->updated_at);
            $order->date = $date->toDayDateTimeString();
        }

        return view('frontpages.orders')->with([
            'active' => '',
            'transaction' => $transaction,
            'orders' => $orders
        ]);
    }

    public function orderDetail(Request $req)
    {
        $id = $req->input('id');
        $order = Order::find($id);
        $city = City::find($order->city_id);
        $order->device_used = Device::find($order->device_used_id);
        $order->plan_name = explode(':', $order->plan)[0];
        $order->plan_price = explode(':', $order->plan)[1];
        $order->state = self::getOrderState($order->state);
        $order->payment_type = self::getOrderPayment($order->payment_type);
        $orderValues = self::getOrderValues($order);

        if (!is_null($order->device_new_id)) {
            $order->device_new = Device::find($order->device_new_id);
            $order->device_new['price'] = $orderValues['device_new'];
        }
        $order->device_used['price'] = $orderValues['device_used'];
        $order->delivery_city = $city->name;

        $order->result = $orderValues['total'];

        return response()->json(['success' => true, 'data' => $order]);
    }

    public function onDeliver($ref)
    {
        $order = Order::where('reference', '=', $ref)->first();

        if (count($order) > 0) {
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
            $used->inventory = $used->inventory()->where('seller_id', '=', 1)->first();
            $used->price = '$'.number_format($used->inventory[
                self::getDeviceState($order->device_used_state)
            ]);

            return view('frontpages.ondeliver')->with([
                'order' => $order,
                'new' => $new,
                'used' => $used
            ]);
        } else {
            return redirect('/');
        }
    }

    public function processOnDeliver(Request $request)
    {
        $ref = $request->input('order');
        $order = Order::where('reference', '=', $ref)->first();

        if (count($order) > 0) {
            $id = Auth::guard('customer')->user()->id;
            $customer = Customer::find($id);
            $customer->phone = $request->input('customer_phone');
            $customer->email = $request->input('customer_email');
            $order->imei = $request->input('user_imei');
            $order->customer_id = $id;
            $order->state = 2;
            $order->save();

            self::sendSellConfirmationMail($order);
            $response['redirect'] = '/usuario/dashboard/approved';

            return response()->json([
                'success' => true,
                'data' => $response
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'No se puede procesar la orden ingresada.'
            ]);
        }
    }

    public static function sendSellConfirmationMail($order)
    {
        $customer = Customer::find($order->customer_id);
        $city = City::find($order->city_id);
        $orderDate = Carbon::parse($order->updated_at);
        $order->date = $orderDate->toDayDateTimeString();
        $deliveryDate = Carbon::parse($order->delivery_date);
        $order->delivery_date = $deliveryDate->toFormattedDateString().' en la '. $order->delivery_time;
        $orderValues = self::getOrderValues($order);
        if (!is_null($order->device_new_id)) {
            $device_new = Device::find($order->device_new_id);
            $device_new->price = '$'.number_format($orderValues['device_new']);
            $device_new->state = self::getStateOfNewCelucambio($order->device_new_state);
            $data['device_new'] = $device_new;
        }
        $device_used = Device::find($order->device_used_id);
        $device_used->state = self::getStateOfUsed($order->device_used_state);
        $device_used->price = '$'.number_format($orderValues['device_used']);
        $order->payment_type = self::getOrderPayment($order->payment_type);
        $order->delivery_city = $city->name;
        $order->value = '$'.number_format($order->value);
        $data['customer'] = $customer;
        $data['device_used'] = $device_used;
        $data['order'] = $order;

        Mail::send('emails.sellconfirmation', $data,
                   function ($m) use ($customer) {
                       $m->from('info@etbtelocambio.co', 'ETB Te lo cambio');
                       $m->to($customer->email, $customer->name)
                           ->subject('Confirmación de cambio - venta')->cc('info@etbtelocambio.co');
                   });
    }

    /**
     * Return order values array depending on smartphones
     *
     * @return array
     */
    public static function getOrderValues($order)
    {
        $values = [];

        $deviceNew = Device::find($order->device_new_id);
        $deviceUsed = Device::find($order->device_used_id);

        $newInventory = $deviceNew->inventory()->where('seller_id', '=', $order->seller_id)->first();
        $usedInventory = $deviceUsed->inventory()->where('seller_id', '=', $order->seller_id)->first();
        $plan = explode(':', $order->plan);

        $values['device_new'] = self::getNewPrice($newInventory, $order->device_new_state, $plan[0]);
        $values['device_used'] = self::getUsedPrice($usedInventory, $order->device_used_state);
        $values['total'] = (int) ($values['device_new'] + $plan[1]) - $values['device_used'];

        return $values;
    }

    /**
     * Remove device from stock after successful order
     *
     * @return void
     */
    public static function updateDeviceStock($order)
    {
        $device = Device::find($order->device_new_id);
        $inventory = $device->inventory()->where('seller_id', '=', $order->seller_id)->first();

        if ($order->device_new_state == 1) {
            $inventory->stock_new = $inventory->stock_new - 1;
            $inventory->save();
        } else {
            $inventory->stock_used = $inventory->stock_used - 1;
            $inventory->save();
        }
    }

    /**
     * Return price based on seller inventory and state of device
     *
     * @return String
     */
    public static function getUsedPrice($inventory, $state)
    {
        switch($state) {
        case 3:
            return $inventory['receive_excelent'];
            break;
        case 2:
            return $inventory['receive_good'];
            break;
        case 1:
            return $inventory['receive_aceptable'];
            break;
        case 0:
            return $inventory['receive_defective'];
            break;
        }
    }

    public static function getStateOfNewETB($state)
    {
        if ($state == 1) {
            return 'Nuevo';
        } else {
            return 'Como Nuevo';
        }
    }

    public static function getStateOfNewCelucambio($state)
    {
        if ($state == 1) {
            return 'Como Nuevo';
        } else {
            return 'Económico';
        }
    }

    public static function getStateOfUsed($state)
    {
        switch($state) {
        case 3:
            return 'Excelente';
            break;
        case 2:
            return 'Bueno';
            break;
        case 1:
            return 'Aceptable';
            break;
        case 0:
            return 'Defectuoso';
            break;
        }
    }

    public static function getDeviceState($state)
    {
        $txt = '';
        switch($state) {
        case 3:
            $txt = 'receive_excelent';
            break;
        case 2:
            $txt = 'receive_good';
            break;
        case 1:
            $txt = 'receive_aceptable';
            break;
        case 0:
            $txt = 'receive_defective';
            break;
        }

        return $txt;
    }

    public static function getOrderState($state)
    {
        switch($state) {
        case 1:
            return 'Sin procesar';
            break;
        case 2:
            return 'Aprobada';
            break;
        case 3:
            return 'Rechazada';
            break;
        case 4:
            return 'Pendiente';
            break;
        case 5:
            return 'Falló';
            break;
        }
    }

    public static function getOrderPayment($payment)
    {
        switch($payment) {
        case 1:
            return 'Tarjeta de crédito';
            break;
        case 2:
            return 'Efecty - Baloto';
            break;
        case 3:
            return 'PSE';
            break;
        case 4:
            return 'Contraentrega';
            break;
        default:
            return 'No se ha especificado';
        }
    }

    public static function getShortDocumentType($type)
    {
        $txt = '';
        switch($type) {
        case 2:
            $txt = 'CE.';
            break;
        case 1:
            $txt = 'CC.';
            break;
        }

        return $txt;
    }

    public static function getLongDocumentType($type)
    {
        $txt = '';
        switch($type) {
        case 2:
            $txt = 'Cédula de extranjería';
            break;
        case 1:
            $txt = 'Cédula de ciudadania';
            break;
        }

        return $txt;
    }


    private static function getNewPrice($inventory, $state)
    {
        $price = 0;

        if ($state == 2) {
            $price = $inventory['sell_affordable'];
        } else {
            $price = $inventory['sell_new'];
        }

        return $price;
    }

    /**
     * Return the value of the used offer
     *
     * @return Int
     */
    private function getDeviceOffer($device, $state)
    {
        $offer = 0;

        switch($state) {
        case 3:
            $offer = $device['inventory']['receive_excelent'];
            break;
        case 2:
            $offer = $device['inventory']['receive_good'];
            break;
        case 1:
            $offer = $device['inventory']['receive_aceptable'];
            break;
        case 0:
            $offer = $device['inventory']['receive_defective'];
            break;
        }

        return $offer;
    }
}
