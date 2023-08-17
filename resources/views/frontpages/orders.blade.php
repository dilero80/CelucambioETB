@extends('layouts.default')

@section('content')
@include('partials.header')
<section class="etb orders">
    <div class="container">
        <div class="row">
            @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
            @endif
            <div class="col-md-6">
                <h1>Historial</h1>
                <p>Encuentra aquí el estado de los canjes realizados en la plataforma ETB</p>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5 new-exchange">
                <br/>
                <a href="{{url('/')}}">
                    <button class="btn btn-exchange">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Hacer nuevo canje
                    </button>
                </a>
            </div>
            <div class="col-md-12">
                <div class="orders-wrapper">
                    @if (count($orders) === 0)
                    <div class="no-orders">
                        <p>Todavía no has realizado ninguna transacción</p>
                        <hr/>
                        <p>Cambiar tu viejo smartphone por uno nuevo con ETB es muy fácil.</p>
                        <p>Oprime el botón para comenzar</p>
                        <a href="{{url('/')}}">
                            <button class="btn btn-exchange">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                Hacer nuevo canje
                            </button>
                        </a>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="orders-list list-group">
                                @forEach ($orders as $order)
                                <li id="{{$order->id}}" class="order-item list-group-item">
                                    <table class="order">
                                        <tbody>
                                            <tr>
                                                <td class="state-icon">
                                                    <span class="glyphicon glyphicon-ok-circle"
                                                          aria-hidden="true"></span>
                                                </td>
                                                <td class="description">
                                                    <div class="name">
                                                        <p>{{$order->name}}</p>
                                                        <p class="date">{{$order->delivery_date}}</p>
                                                    </div>
                                                </td>
                                                <td class="pointer">
                                                    <span class="glyphicon glyphicon-triangle-right"
                                                          aria-hidden="true"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div id="order-detail" class="col-md-6"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!--transaction approved modal-->
    <div id="approved-modal" class="transaction-modal modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">¡Felicitaciones!</h4>
                    <p>Tu transacción ha sido exitosa</p>
                </div>
                <div class="modal-body">
                    <img src="{{url('images/ic_exitoso.png')}}"/>
                    <p><br/>
                        Espera la llamada de uno de nuestros agentes de servicio al cliente, para
                        hacer la validación final de la transacción.
                    </p>
                    <button class="btn" data-dismiss="modal" aria-labell="Close">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    <!--transaction declined modal-->
    <div id="declined-modal" class="transaction-modal modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Lo sentimos</h4>
                    <p>Tu transacción fué rechazada :(</p>
                </div>
                <div class="modal-body">
                    <img src="{{url('images/ic_rechazado.png')}}"/>
                    <p><br/>
                        Espera la llamada de uno de nuestros agentes de servicio al cliente, para
                        revisar los detalles de la transacción.
                    </p>
                    <button class="btn" data-dismiss="modal" aria-labell="Close">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    <!--transaction pending modal-->
    <div id="pending-modal" class="transaction-modal modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">¡Estamos casi listos!</h4>
                    <p>Tu transacción está pendiente de confirmación</p>
                </div>
                <div class="modal-body">
                    <img src="{{url('images/ic_pendiente.png')}}"/>
                    <p><br/>
                        Tu transacción está pendiente de confirmación, pero no te preocupes
                        estamos corriendo para confirmarte si ha sido aprobada. </br>
                        Espera la llamada de uno de nuestros agentes de servicio al cliente, para
                        revisar los detalles de la transacción.
                    </p>
                    <p>
                        Si realizaste la transacción a través de <strong>Baloto</strong> ó
                        <strong>Efecty</strong>, ingresa al detalle de la orden y
                        haz click en el botón <strong>Descargar PDF</strong> para obtener
                        tu factura de pago.
                    </p>
                    <button class="btn" data-dismiss="modal" aria-labell="Close">Continuar</button>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('scripts')
    @if($transaction === 'approved')
    <script>
     $('#approved-modal').modal();
    </script>
    @endif

    @if($transaction === 'declined')
    <script>
    $('#declined-modal').modal();
    </script>
    @endif

    @if($transaction === 'pending')
    <script>
    $('#pending-modal').modal();
    </script>
    @endif

    <script>
      function getDetailTmpl(data) {
        return  '<div class="sell-summary">'+
                   '<table class="operation">'+
                      '<tbody>'+
                          '<tr>'+
                              '<td>'+
                                  '<label>Estás comprando el smartphone:</label>'+
                                  '<p class="buy-device-name">'+data.device_new.name+'</p>'+
                              '</td>'+
                              '<td class="buy-device-price">'+numeral(data.device_new.price).format('$0,0')+'</td>'+
                          '</tr>'+
                          '<tr>'+
                              '<td>'+
                                  '<label>Tu plan es:</label>'+
                                  '<p class="plan-name">'+data.plan_name+'</p>'+
                              '</td>'+
                              '<td class="plan-price">'+numeral(data.plan_price).format('$0,0')+'</td>'+
                          '</tr>'+
                          '<tr>'+
                              '<td>'+
                                  '<label>Estas vendiendo el smartphone:</label>'+
                                  '<p class="sell-device-name">'+data.device_used.name+'</p>'+
                              '</td>'+
                              '<td class="sell-device-price">'+numeral(data.device_used.price).format('$0,0')+'</td>'+
                          '</tr>'+
                          '<tr>'+
                              '<td class="result">Saldo a pagar</td>'+
                              '<td class="result result-price">'+numeral(data.result).format('$0,0')+'</td>'+
                          '</tr>'+
                      '</tbody>'+
                  '</table>'+
                  '<table class="order-info">'+
                      '<tbody>'+
                          '<tr>'+
                              '<td>Estado de la orden</td>'+
                              '<td>'+data.state+'</td>'+
                          '</tr>'+
                          '<tr>'+
                              '<td>Forma de pago</td>'+
                              '<td>'+data.payment_type+'</td>'+
                          '</tr>'+
                          '<tr>'+
                              '<td>Fecha de envío</td>'+
                              '<td>'+data.delivery_date+'</td>'+
                          '</tr>'+
                          '<tr>'+
                              '<td>Dirección de envío</td>'+
                              '<td>'+data.delivery_address+'</td>'+
                          '</tr>'+
                          '<tr>'+
                              '<td>Ciudad de envío</td>'+
                              '<td>'+data.delivery_city+'</td>'+
                          '</tr>'+
                          getResumeOrderBtn(data.state, getOrderUrl(data.reference, data.payment_type))+
                          getPaymentReceipt(data.payment_type, getReceiptLink(data.payment_type, data.transaction_response))+
                      '</tbody>'+
                  '</table>'+
                '</div>';
      }

      function getOrderUrl(reference, payment) {
          var locationArray = window.location.pathname.split('dashboard');
          if (payment == 'Contraentrega') {
              return locationArray[0]+'contraentrega/'+reference
          } else {
              return locationArray[0]+'checkout/'+reference;
          }
      }

      function getReceiptLink(payment, res) {
        if (payment == 'Efecty - Baloto') {
            var response = JSON.parse(res);
            return response.extraParameters.URL_PAYMENT_RECEIPT_PDF;
        }
      }

      function getResumeOrderBtn(state, link) {
          var tmpl = '';
          if (state == 'Sin procesar') {
              tmpl = '<tr>'+
                       '<td>Terminar pago</td>'+
                       '<td>'+
                         '<a href="'+link+'">'+
                           '<button type="submit" class="btn btn-action">'+
                             'Ir a la orden'+
                           '</button>'+
                         '</a>'+
                       '</td>'+
                     '</tr>';
          }

          return tmpl;
      }

      function getPaymentReceipt(payment, link) {
         var tmpl = '';
          if (payment == 'Efecty - Baloto') {
              tmpl = '<tr>'+
                       '<td>Imprimir recibo de pago</td>'+
                       '<td>'+
                         '<a href="'+link+'">'+
                           '<button type="submit" class="btn btn-action">'+
                             'Descargar PDF'+
                           '</button>'+
                         '</a>'+
                       '</td>'+
                     '</tr>';
          }

          return tmpl;
      }

      var loader = '<div id="loading-wrapper">'+
                      '<div class="spinner">'+
                         ' <div class="rect1"></div>'+
                          '<div class="rect2"></div>'+
                          '<div class="rect3"></div>'+
                          '<div class="rect4"></div>'+
                          '<div class="rect5"></div>'+
                      '</div>'+
                      '<p>Cargando...</p>'+
                   '</div>';

      var orderDetail = $('#order-detail');

     $('.order-item').click(function() {
          var id = $(this).attr('id');
          orderDetail.html(loader);
          utils.setAjaxToken();
          utils.sendData({
              url: '/usuario/order',
              data: {id: id},
              onSuccess: function(res) {
                  if (res.success) {
                    orderDetail.html(getDetailTmpl(res.data));
                  }else{
                      orderDetail.html('Ha ocurrido un error al cargar la orden');
                  }
              }
          });
     });
     </script>
@stop
