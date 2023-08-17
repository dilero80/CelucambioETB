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
                        @if (!is_null($new))
                        <tr>
                            <td>
                                <label>Estás comprando el smartphone:</label>
                                <p class="buy-device-name">{{$new->name}}</p>
                            </td>
                            <td class="buy-device-price">{{$new->price}}</td>
                        </tr>
                        @endif
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
                            <td class="shipment-date">{{$order->delivery_date}} en la {{$order->delivery_time}}</td>
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
            <form id="form-etb-ondeliver">
                <div class="subtitle payment-subtitle">Información sobre el equipo</div>
                <div class="panel panel-default sell-summary">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true">
                                </span>
                            </div>
                            <input id="etb-imei" class="form-control" name="user_imei"
                                   type="text" maxlength="25" placeholder="Imei del equipo que cambias"/>
                        </div><br/>
                        <a class="clr-sell-dark" data-toggle="modal" data-target="#imei-modal">
                            ¿Cómo conocer el imei de mi equipo?
                        </a>
                    </div>
                </div>
                <div class="subtitle payment-subtitle">Confirmanos tus datos de contacto</div>
                <div class="panel panel-default sell-summary">
                     <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-envelope" aria-hidden="true">
                                </span>
                            </div>
                            <input class="form-control"
                                   name="customer_email" type="email" maxlength="90"
                                   placeholder="Correo" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-phone" aria-hidden="true">
                                </span>
                            </div>
                            <input id="etb-payer-phone" class="form-control"
                                   name="customer_phone" type="text" maxlength="11"
                                   placeholder="Teléfono" />
                        </div>
                    </div>
                    <div class="form-group form-inline">
                        <div class="form-group terms">
                            <div class="checkbox">
                                <label>
                                    <input id="terms-check-ondeliver" type="checkbox" name="terms">
                                    He leído y estoy de acuerdo con los
                                    <a href="{{url('terminos_y_condiciones_celucambio.com.pdf')}}"
                                       target="_blank">
                                        términos y condiciones
                                    </a>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="ondeliver-loading" class="hidden ondelivery-loader">
                                <img src="{{url('images/payu_loader.gif')}}"/>
                                Procesando orden
                            </div>
                            <button id="btn-finish-ondeliver" class="btn btn-sell">Terminar</button>
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

