 <div class="container">
     <form id="exchange-step3">
         <div class="row">
             <div class="col-md-5">
                 <h1>3. Escoge tu plan</h1>
                 <p>
                     En ETB tenemos una amplia oferta de planes para que hables y navegues
                     sin parar.
                 </p>
                 <p>Escoge el tuyo</p>
                 <br>
             </div>
             <div class="col-md-2"></div>
             <div class="col-md-5">
                 <br>
                 <div class="form-group">
                     <div class="device-offer">
                         <p>
                             <span class="glyphicon glyphicon-ok-circle" aria-hidden="true">
                             </span>
                             Tienes <span class="amount">$0</span>
                             de saldo disponible
                         </p>
                         <p>
                             <span class="glyphicon glyphicon-ok-circle" aria-hidden="true">
                             </span>
                             Tu nuevo smartphone es el <span class="new-device"></span>
                         </p>
                     </div>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-md-12">
                 <div id="etb-plans">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs" role="tablist">
                         <li role="presentation" class="active">
                             <a href="#prepaid" aria-controls="prepaid" role="tab"
                                data-toggle="tab">
                                 <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                 Prepago
                             </a>
                         </li>
                         <li role="presentation" class="plan-tab">
                             <a href="#open-plan" aria-controls="open-plan" role="tab"
                                data-toggle="tab">
                                 <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                 Pospago Abierto
                             </a>
                         </li>
                         <li role="presentation" class="plan-tab">
                             <a href="#control-plan" aria-controls="control-plan" role="tab"
                                data-toggle="tab">
                                 <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                 Pospago Control
                             </a>
                         </li>
                     </ul>

                     <!-- Tab panes -->
                     <div class="tab-content">
                         <div role="tabpanel" class="tab-pane active" id="prepaid">
                             <div class="prepaid-img">
                                 <picture>
                                     <source srcset="{{url('images/prepaid_desktop.jpg')}}"
                                             media="(min-width: 768px)" />
                                     <img srcset="{{url('images/prepaid_mobile.jpg')}}"
                                          alt="ETB plan prepago" />
                                 </picture>
                                 <button class="btn btn-action">Seleccionar</button>
                             </div>
                             <div class="plan-benefits">
                                 <div class="title">Beneficios permanentes</div>
                                 <div class="benefits">
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_facebook-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     <br/>
                                                     Usa Facebook sin consumir de tu bolsa / plan
                                                     de datos. PUJ de 250MB, vigencia de la bolsa
                                                     (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_whatsapp-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     <br/>
                                                     Usa WhatsApp sin consumir de tu bolsa / plan
                                                     de datos. PUJ de 250MB, vigencia de la bolsa
                                                     (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div role="tabpanel" class="tab-pane plan-content" id="open-plan">
                             <table class="open-plan">
                                 <tbody>
                                     <tr>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$30.000</div>
                                                     <div class="name">Call Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         200 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="messages">5 SMS</div>
                                                     <div class="minutes">200 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <i class="icon whatsapp"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$32.000</div>
                                                     <div class="name">Like Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         200 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">1GB</div>
                                                     <div class="minutes">100 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$37.000</div>
                                                     <div class="name">Mega Like Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         300 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">1.5GB</div>
                                                     <div class="minutes">150 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$43.000</div>
                                                     <div class="name">Selfie Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         400 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">2GB</div>
                                                     <div class="minutes">100 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$55.000</div>
                                                     <div class="name">Cool Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         600 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">3GB</div>
                                                     <div class="minutes">300 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                     </tr>
                                     <tr>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible colored">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$77.000</div>
                                                     <div class="name">Play Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         1.000 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">5GB</div>
                                                     <div class="minutes">500 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$120.000</div>
                                                     <div class="name">Extreme Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         1.800 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">8GB</div>
                                                     <div class="minutes">900 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$140.000</div>
                                                     <div class="name">Supreme Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         2.400 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">12GB</div>
                                                     <div class="minutes">1200 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$155.000</div>
                                                     <div class="name">King Pospago</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         2.400 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">20GB red 4G</div>
                                                     <div class="minutes">1200 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                             <div class="plan-benefits open-plan">
                                 <div class="title">Beneficios permanentes</div>
                                 <div class="benefits">
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_facebook-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Usa Facebook sin consumir de tu bolsa / plan
                                                     de datos. PUJ de 250MB, vigencia de la bolsa (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_whatsapp-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Usa WhatsApp sin consumir de tu bolsa / plan
                                                     de datos. PUJ de 250MB, vigencia de la bolsa (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!--<div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_email-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Envia y recibe emails sin consumir de tu bolsa
                                                     / plan de datos. PUJ de 250MB, vigencia de la
                                                     bolsa (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>-->
                                     <!--<div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_spotify-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     <br/>
                                                     Incluye el costo de suscripción mensual del
                                                     app de música Spotify durante 12 meses.
                                                     <br/><br/>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>-->
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_prolonga-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Los nuestros nunca pierden minutos, ni datos;
                                                     nosotros te los guardamos
                                                     para el mes siguiente. Vigencia 30 días.
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div role="tabpanel" class="tab-pane plan-content" id="control-plan">
                             <table class="control-plan">
                                 <tbody>
                                     <tr>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$30.000</div>
                                                     <div class="name">Call Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         200 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="messages">5 SMS</div>
                                                     <div class="minutes">200 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <i class="icon whatsapp"></i>
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$32.000</div>
                                                     <div class="name">Like Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         200 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">1GB</div>
                                                     <div class="minutes">100 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <!--<i class="icon facebook"></i>-->
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$37.000</div>
                                                     <div class="name">Mega Like Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         300 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">1GB</div>
                                                     <div class="minutes">150 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$43.000</div>
                                                     <div class="name">Selfie Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         400 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">2GB</div>
                                                     <div class="minutes">100 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$55.000</div>
                                                     <div class="name">Cool Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         600 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">3GB</div>
                                                     <div class="minutes">300 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                     </tr>
                                     <tr>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible colored">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$77.000</div>
                                                     <div class="name">Play Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         1.000 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">5GB</div>
                                                     <div class="minutes">500 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$120.000</div>
                                                     <div class="name">Extreme Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         1.800 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">8GB</div>
                                                     <div class="minutes">900 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$140.000</div>
                                                     <div class="name">Supreme Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         2.400 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">12GB</div>
                                                     <div class="minutes">1200 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                         <td>
                                             <div class="plan-item">
                                                 <div class="promo invisible">Promoción</div>
                                                 <div class="top">
                                                     <div class="price">$155.000</div>
                                                     <div class="name">King Control</div>
                                                 </div>
                                                 <div class="medium">
                                                     <div class="promo">
                                                         2.400 min Whatsapp
                                                     </div>
                                                 </div>
                                                 <div class="bottom">
                                                     <div class="size">20GB red 4G</div>
                                                     <div class="minutes">1200 Minutos</div>
                                                     <div class="includes">
                                                         <p>Incluye:</p>
                                                         <!--<i class="icon spotify"></i>-->
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon whatsapp"></i>
                                                         <i class="icon facebook"></i>
                                                         <!--<i class="icon email"></i>-->
                                                     </div>
                                                     <button class="btn btn-action">
                                                         Seleccionar
                                                     </button>
                                                 </div>
                                             </div>
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                             <div class="plan-benefits open-plan">
                                 <div class="title">Beneficios permanentes</div>
                                 <div class="benefits">
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_facebook-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Usa Facebook sin consumir de tu bolsa / plan
                                                     de datos. PUJ de 250MB, vigencia de la bolsa
                                                     (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_whatsapp-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Usa WhatsApp sin consumir de tu bolsa / plan
                                                     de datos. PUJ de 250MB, vigencia de la bolsa
                                                     (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!--<div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_email-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Envia y recibe emails sin consumir de tu bolsa
                                                     / plan de datos. PUJ de 250MB, vigencia de la bolsa
                                                     (30 días).
                                                 </div>
                                             </div>
                                         </div>
                                     </div>-->
                                     <!--<div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_spotify-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     <br/>
                                                     Incluye el costo de suscripción mensual del
                                                     app de música Spotify durante 12 meses.
                                                     <br/><br/>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>-->
                                     <div class="panel panel-default">
                                         <div class="panel-body">
                                             <div class="media">
                                                 <div class="media-left">
                                                     <a>
                                                         <img class="media-object"
                                                              src="{{url('/images/ic_prolonga-big.png')}}">
                                                     </a>
                                                 </div>
                                                 <div class="media-body">
                                                     Los nuestros nunca pierden minutos, ni datos;
                                                     nosotros te los guardamos
                                                     para el mes siguiente. Vigencia 30 días.
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </form>
 </div>
