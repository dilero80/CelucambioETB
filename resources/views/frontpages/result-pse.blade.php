@extends('layouts.default')

@section('content')
@include('partials.header-no-menu')
<section class="etb pse-result">
    <div class="container">
        <div class="col-md-12">
            <h1 class="title">Resultado de la transacción </h1>
            <div class="panel panel-default sell-summary">
                <label>Operacion:</label>
                <p>{{$transState}}</p>
                <label>Descripción:</label>
                <p>{{$transResponse}}</p>
            </div>
            <div class="panel panel-default sell-summary">
                <div class="subtitle">Resumen de la operación</div>
                <table class="operation">
                    <tbody>
                        <tr>
                            <td>
                                <label>Persona o Empresa</label>
                            </td>
                            <td>{{$customer}}</td>
                        </tr>
                        <tr>
                            <td>
                                <label>Documento</label>
                            </td>
                            <td>{{$dni}}</td>
                        </tr>
                        <tr>
                            <td>
                                <label>Fecha</label>
                            </td>
                            <td>{{$order->date}}</td>
                        </tr>
                        <tr>
                            <td><label>Referencia de pedido</label></td>
                            <td>{{$order->reference}}</td>
                        </tr>
                        <tr>
                            <td><label>Referencia de transacción</label></td>
                            <td>{{$res->transactionId}}</td>
                        </tr>
                        <tr>
                            <td><label>Referencia transacción/CUS </label></td>
                            <td>{{$res->cus}}</td>
                        </tr>
                        <tr>
                            <td><label>Banco</label></td>
                            <td>{{$res->pseBank}}</td>
                        </tr>
                        <tr>
                            <td><label>Valor</label></td>
                            <td>{{'$'.$res->TX_VALUE}}</td>
                        </tr>
                        <tr>
                            <td><label>Moneda</label></td>
                            <td>{{$res->currency}}</td>
                        </tr>
                        <tr>
                            <td><label>Descripción</label></td>
                            <td>{{$res->description}}</td>
                        </tr>
                        <tr>
                            <td><label>IP Origen</label></td>
                            <td>{{$res->pseReference1}}</td>
                        </tr>
                    </tbody>
                </table><br/>
                <div class="form-group">
                    <a href="{{url('usuario/order/complete/'.$order->reference.'/'.$transState)}}">
                        <button class="btn btn-action">Continuar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
