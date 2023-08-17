@extends('layouts.default')

@section('content')
@include('partials.header')
<section class="etb checkout">
    <div class="container">
        <div class="col-md-5">
            <h1 class="title">Confirmar y pagar</h1>
            <div class="panel panel-default sell-summary">
                <div class="subtitle">Resumen de la operación</div>
                <table class="operation">
                    <tbody>
                        <tr>
                            <td>
                                <label>Estás comprando el smartphone:</label>
                                <p class="buy-device-name">{{$new->name}}</p>
                            </td>
                            <td class="buy-device-price">{{$new->price}}</td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tu plan es:</label>
                                <p class="plan-name">{{$plan['name']}}</p>
                            </td>
                            <td class="plan-price">{{$plan['price']}}</td>
                        </tr>
                        <tr>
                            <td>
                                <label>Estas vendiendo el smartphone:</label>
                                <p class="sell-device-name">{{$used->name}}</p>
                            </td>
                            <td class="sell-device-price">{{$used->price}}</td>
                        </tr>
                        <tr>
                            <td class="result">Saldo a pagar</td>
                            <td class="result result-price">{{$order->value}}</td>
                        </tr>
                    </tbody>
                </table><br/>
            </div>
            <div class="panel panel-default sell-summary">
                <div class="subtitle">Datos de envío</div>
                <table class="order-info">
                    <tbody>
                        <tr>
                            <td>Fecha y hora de envío</td>
                            <td class="shipment-date">
                                {{$order->delivery_date}} en la {{$order->delivery_time}}
                            </td>
                        </tr>
                        <tr>
                            <td>Dirección de envío</td>
                            <td class="shipment-address">{{$order->delivery_address}}</td>
                        </tr>
                        <tr>
                            <td>Ciudad de envío</td>
                            <td class="shipment-city">{{$order->city}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-7"><br/>
            <form id="form-etb-payment">
                <div class="subtitle payment-subtitle">Información sobre el equipo</div>
                <div class="panel panel-default sell-summary">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true">
                                </span>
                            </div>
                            <input id="etb-imei" class="form-control" name="user_imei"
                                   type="text" maxlength="25" placeholder="Imei del equipo que cambias"
                                   required/>
                        </div><br/>
                        <a class="clr-sell-dark" data-toggle="modal" data-target="#imei-modal">
                            ¿Cómo conocer el imei de mi equipo?
                        </a>
                    </div>
                </div>
                <div class="subtitle payment-subtitle">Selecciona el medio de pago</div>
                <div class="panel-group" id="payment-types" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default sell-summary bgc-white">
                        <div id="heading-creditcard" class="panel-heading bgc-white" role="tab">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#payment-types"
                                   href="#payment-creditcard" aria-expanded="true"
                                   aria-controls="payment-creditcard">
                                    Tarjeta de crédito
                                </a>
                            </h4>
                        </div>
                        <div id="payment-creditcard" class="panel-collapse collapse in"
                             role="tabpanel" aria-labelledby="payment-creditcard">
                            <div class="panel-body">
                                <div class="form-inline">
                                    <div class="form-group payment-txt">
                                        <span>Pago en línea con tarjeta de crédito:</span>
                                    </div>
                                    <div class="form-group payment">
                                        <i class="card-item visa"></i>
                                        <input name="payment_method" type="radio" value="VISA"/>
                                    </div>
                                    <div class="form-group payment">
                                        <i class="card-item master"></i>
                                        <input name="payment_method" type="radio" value="MASTERCARD"/>
                                    </div>
                                    <div class="form-group payment">
                                        <i class="card-item american"></i>
                                        <input name="payment_method" type="radio" value="AMEX"/>
                                    </div>
                                    <div class="form-group payment">
                                        <i class="card-item diners"></i>
                                        <input name="payment_method" type="radio" value="DINERS"/>
                                    </div>
                                </div><br/>
                                <div class="form-group">
                                    <div class="form-inline">
                                        <div class="input-group card">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-credit-card"
                                                      aria-hidden="true">
                                                </span>
                                            </div>
                                            <input id="etb-card-number" class="form-control"
                                                   name="card_number" type="text" maxlength="19"
                                                   placeholder="Número de la tarjeta"/>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-lock" aria-hidden="true">
                                                </span>
                                            </div>
                                            <input id="etb-card-code" class="form-control"
                                                   name="card_cvc" type="text" maxlength="4"
                                                   placeholder="Código de seguridad"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"
                                                  aria-hidden="true">
                                            </span>
                                        </div>
                                        <input class="form-control" name="payer_name"
                                               type="text" maxlength="50"
                                               placeholder="Nombre en la tarjeta"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"
                                                  aria-hidden="true">
                                            </span>
                                        </div>
                                        <input class="form-control" name="expiration_date"
                                               type="text" maxlength="7"
                                               placeholder="Fecha de expiración: AAAA/MM"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-envelope"
                                                  aria-hidden="true">
                                            </span>
                                        </div>
                                        <input class="form-control" name="payer_email"
                                               type="text" maxlength="80"
                                               placeholder="Correo del titular"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-map-marker"
                                                  aria-hidden="true">
                                            </span>
                                        </div>
                                        <input class="form-control" name="payer_address"
                                               type="text" maxlength="80"
                                               placeholder="Dirección del titular"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-phone"
                                                  aria-hidden="true">
                                            </span>
                                        </div>
                                        <input id="etb-payer-phone" class="form-control"
                                               name="payer_phone" type="text" maxlength="11"
                                               placeholder="Teléfono del titular"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>No. de cuotas</span>
                                        </div>
                                        <select name="installments" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="12">12</option>
                                            <option value="24">24</option>
                                            <option value="36">36</option>
                                            <option value="48">48</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-inline">
                                    <div class="form-group terms">
                                        <div class="checkbox">
                                            <label>
                                                <input id="terms-check-creditcard" type="checkbox"
                                                       name="terms">
                                                He leído y estoy de acuerdo con los
                                                <a href="{{url('terminos_y_condiciones.pdf')}}"
                                                   target="_blank">
                                                    términos y condiciones
                                                </a>
                                                y con <a href="http://www.payulatam.com/imagenes-correos/pdfs/T&C%20PARA%20PAGADORES%20%2023%2003%2016.pdf" target="_blank">
                                                    las políticas y tratamientos de datos personales</a>.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="credit-card-loading" class="hidden payu-loader">
                                            <img src="{{url('images/payu_loader.gif')}}"/>
                                            Conectando con PayU
                                        </div>
                                        <button id="btn-etb-creditcard" class="btn btn-sell">Pagar</button>
                                        <p class="payment-secure-txt">
                                            <span class="glyphicon glyphicon-lock" aria-hidden="true">
                                            </span>
                                            Pago Seguro con
                                            <img class="img-responsive" alt="PayU" src="{{url('images/payu.png')}}"/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default sell-summary bgc-white">
                        <div id="heading-paymentpoint" class="panel-heading bgc-white" role="tab">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#payment-types"
                                   href="#payment-point" aria-expanded="true"
                                   aria-controls="payment-point">
                                    Pago en efectivo
                                </a>
                            </h4>
                        </div>
                        <div id="payment-point" class="panel-collapse collapse"
                             role="tabpanel" aria-labelledby="payment-point">
                            <div class="panel-body">
                                <div class="form-inline">
                                    <div class="form-group payment-txt">
                                        <span>Pago en efectivo en puntos autorizados:</span>
                                    </div>
                                    <div class="form-group payment">
                                        <i class="point-item efecty"></i>
                                        <input name="payment_method" type="radio" value="EFECTY"/>
                                    </div>
                                    <div class="form-group payment">
                                        <i class="point-item baloto"></i>
                                        <input name="payment_method" type="radio" value="BALOTO"/>
                                    </div>
                                </div><br/>
                                <div class="form-group form-inline">
                                    <div class="form-group terms">
                                        <div class="checkbox">
                                            <label>
                                                <input id="terms-check-cash" type="checkbox" name="terms">
                                                He leído y estoy de acuerdo con los
                                                <a href="{{url('terminos_y_condiciones.pdf')}}" target="_blank">
                                                    términos y condiciones
                                                </a>
                                                y con <a href="http://www.payulatam.com/imagenes-correos/pdfs/T&C%20PARA%20PAGADORES%20%2023%2003%2016.pdf" target="_blank">las políticas y tratamientos de datos personales</a>.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="cash-loading" class="hidden payu-loader">
                                            <img src="{{url('images/payu_loader.gif')}}"/>
                                            Conectando con PayU
                                        </div>
                                        <button id="btn-etb-cash" class="btn btn-sell">Generar recibo</button>
                                        <p class="payment-secure-txt">
                                            <span class="glyphicon glyphicon-lock" aria-hidden="true">
                                            </span>
                                            Pago Seguro con
                                            <img class="img-responsive" alt="PayU" src="{{url('images/payu.png')}}"/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default sell-summary bgc-white">
                        <div id="heading-paymentpse" class="panel-heading bgc-white" role="tab">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#payment-types"
                                   href="#payment-pse"
                                   aria-controls="payment-pse">
                                    PSE
                                </a>
                            </h4>
                        </div>
                        <div id="payment-pse" class="panel-collapse collapse"
                             role="tabpanel" aria-labelledby="payment-pse">
                            <div class="panel-body">
                                <div class="form-inline">
                                    <div class="form-group payment-txt">
                                        <span>Pago en línea cuenta de ahorros o corriente:</span>
                                    </div>
                                    <div class="form-group payment">
                                        <i class="online-item pse"></i>
                                        <input name="payment_method" type="radio" value="PSE"/>
                                    </div>
                                </div><br/>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>Banco</span>
                                        </div>
                                        <select name="bank" class="form-control">
                                            @foreach($banks as $bank)
                                            <option value="{{$bank->pseCode}}">{{$bank->description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>Nombre del títular</span>
                                        </div>
                                        <input name="payer_name_account" type="text"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>Tipo de cliente</span>
                                        </div>
                                        <select name="payer_person_type" class="form-control">
                                            <option value="N">Persona Natural</option>
                                            <option value="J">Persona Jurídica</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>Tipo de documento</span>
                                        </div>
                                        <select name="payer_document_type" class="form-control">
                                            <option value="CC">C.C. Cédula de ciudadanía</option>
                                            <option value="CE">C.E. Cédula de extranjería</option>
                                            <option value="NIT">NIT (Si es empresa)</option>
                                            <option value="TI">TI Tarjeta de Identidad</option>
                                            <option value="PP">PP Pasaporte</option>
                                            <option value="RC">RC Regístro civil</option>
                                            <option value="DC">DC Documento extranjero</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>Número de documento</span>
                                        </div>
                                        <input name="payer_dni" type="text"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span>Télefono</span>
                                        </div>
                                        <input name="payer_pse_phone" type="text"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group form-inline">
                                    <div class="form-group terms">
                                        <div class="checkbox">
                                            <label>
                                                <input id="terms-check-pse" type="checkbox" name="terms">
                                                He leído y estoy de acuerdo con los
                                                <a href="{{url('terminos_y_condiciones.pdf')}}" target="_blank">
                                                    términos y condiciones
                                                </a>
                                                y con <a href="http://www.payulatam.com/imagenes-correos/pdfs/T&C%20PARA%20PAGADORES%20%2023%2003%2016.pdf" target="_blank">las políticas y tratamientos de datos personales</a>.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="pse-loading" class="hidden payu-loader">
                                            <img src="{{url('images/payu_loader.gif')}}"/>
                                            Conectando con PSE
                                        </div>
                                        <button id="btn-etb-pse" class="btn btn-sell">Pagar</button>
                                        <p class="payment-secure-txt">
                                            <span class="glyphicon glyphicon-lock" aria-hidden="true">
                                            </span>
                                            Pago Seguro con
                                            <img class="img-responsive" alt="PayU" src="{{url('images/payu.png')}}"/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--imei modal-->
    <div id="imei-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Imei del equipo</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Para conocer el imei de tu equipo digita *#06# en el teclado
                        de tu teléfono.
                    </p>
                    <button class="btn btn-action" data-dismiss="modal" aria-label="Close">
                        ¡Entendido!
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
