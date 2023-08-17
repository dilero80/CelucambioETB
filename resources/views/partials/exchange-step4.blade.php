 <div class="container">
     <form id="exchange-step4">
         <div class="row">
             <div class="col-md-5">
                 <h1>4. Agenda y confirma</h1>
                 <p>
                     Agenda la fecha y el lugar donde quieres que recojamos tu smartphone sin
                     costo alguno. El valor de la venta ya está cargado a tu cuenta de usuario,
                     recuerda que el equipo que nos estás entregando en parte de pago está sujeto
                     a la valoración por parte de nuestro personal.
                 </p>
                 <br>
                 <div class="form-group">
                     <select class="form-control" id="cities-select" name="city_id">
                         <option value="">Selecciona tu ciudad</option>
                         @foreach ($cities as $city)
                             <option value="{{$city->id}}">{{$city->name}}</option>
                         @endforeach
                     </select>
                 </div>
                 <div class="form-group">
                     <input class="form-control" name="customer_address"
                            placeholder="Escribe tu dirección" type="text" maxlength="80"/>
                 </div>

                 <div class="form-inline">
                     <label>Confirma la fecha de envío*</label><br/>
                     <div class="form-group">
                         <div class="input-group">
                             <input class="form-control datepicker" name="shipment_date"
                                    placeholder="día/mes/año" type="text" maxlength="8"/>
                             <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <div class="input-group">
                             <select name="shipment_time" class="form-control">
                                 <option value="mañana">Mañana</option>
                                 <option value="tarde">Tarde</option>
                             </select>
                             <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="form-group">
                     <p class="explanation">
                         *En esta fecha enviaremos a uno de nuestros agentes comerciales a
                         la dirección indicada, quien validará el estado de tu equipo y te
                         hará entrega del nuevo smartphone. Es indispensable que estés presente
                         en esta dirección en la fecha indicada o que dejes a alguien encargado
                         para realizar la transacción.
                     </p>
                 </div>
             </div>
             <div class="col-md-1"></div>
             <div class="col-md-6">
                 <br>
                 <div class="panel panel-default sell-summary">
                     <div class="title">Resumen de la operación</div>
                     <table class="operation">
                         <tbody>
                             <tr>
                                 <td>
                                     <label>Estás comprando el smartphone:</label>
                                     <p class="buy-device-name"></p>
                                 </td>
                                 <td class="buy-device-price">$0</td>
                             </tr>
                             <tr>
                                 <td>
                                     <label>Tu plan es:</label>
                                     <p class="plan-name"></p>
                                 </td>
                                 <td class="plan-price">$0</td>
                             </tr>
                             <tr>
                                 <td>
                                     <label>Estas vendiendo el smartphone:</label>
                                     <p class="sell-device-name"></p>
                                 </td>
                                 <td class="sell-device-price">$0</td>
                             </tr>
                             <tr>
                                 <td class="result">Saldo a pagar</td>
                                 <td class="result result-price">$0</td>
                             </tr>
                         </tbody>
                     </table><br/>
                     <div class="title">Selecciona la forma de pago</div>
                     <table class="payment-opts">
                         <tbody>
                             <tr>
                                 <td>
                                     <div class="media">
                                         <div class="media-left">
                                             <img class="media-object"
                                                  src="{{url('/images/ic_PayU.png')}}">
                                         </div>
                                         <div class="media-body">
                                             <div class="pull-left">
                                                 <h4 class="media-heading">En línea</h4>
                                                 <p class="desc-payonline">
                                                     Realiza tu pago en línea de forma segura por
                                                     medio de PayU.
                                                 </p>
                                                 <p>- Tarjeta de crédito</p>
                                                 <p>- Efecty, Baloto</p>
                                                 <p>- PSE</p>
                                             </div>
                                             <div class="pull-right">
                                                 <button id="btn-online-etb" class="btn btn-action">
                                                     Pagar en línea
                                                 </button>
                                             </div>
                                         </div>
                                     </div>
                                 </td>
                             </tr>
                             <tr>
                                <td>
                                    <div class="media">
                                        <div class="media-left">
                                            <img class="media-object"
                                                 src="{{url('/images/ic_contraentrega.png')}}">
                                        </div>
                                        <div class="media-body">
                                            <div class="pull-left">
                                                <h4 class="media-heading">Contraentrega</h4>
                                                Realiza tu pago al recibir el equipo.
                                            </div>
                                            <div class="pull-right">
                                                <button id="btn-ondeliver-etb" class="btn btn-action">
                                                    Contraentrega
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="appreciation-msg">
                                        *Recuerda que el equipo que nos estás
                                        entregando en parte de pago está sujeto a la valoración
                                        por parte de nuestro personal. Si por algún motivo tu
                                        smartphone usado no cumple con el estado que indicaste,
                                        deberás pagar la diferencia en el momento de la entrega
                                        de tu nuevo celular.
                                    </p>
                                </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </form>
 </div>
