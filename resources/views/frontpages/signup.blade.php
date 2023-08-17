@extends('layouts.default')

@section('content')
<section class="etb auth">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-wrapper">
                    <form id="signup-etb">
                        <div class="top">
                            <a href="{{url('/')}}">
                                <img src="{{url('images/etb_logo.png')}}" alt="ETB"/>
                            </a>
                        </div>
                        <div class="bottom">
                            <div class="step-1">
                                <div class="form-group">
                                    <h1>
                                        Regístrate
                                        <small>completamente gratis</small>
                                    </h1>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tu nombre completo"
                                           name="name" type="text" maxlength="80"/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tu correo"
                                           name="email" type="email" maxlength="100"/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña"
                                           name="password" type="password" maxlength="40"/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirmar Contraseña"
                                           name="password_repeat" type="password" maxlength="40"/>
                                </div>
                                <div class="form-group">
                                    <select id="type-id" class="form-control"
                                            name="identification_type">
                                        <option value="">Selecciona el tipo de documento</option>
                                        <option value="1">Cédula de ciudadania</option>
                                        <option value="2">Cédula de extranjería</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">-</div>
                                        <input id="signup-identification" class="form-control"
                                               placeholder="Número de documento"
                                               name="identification" type="text" maxlength="14" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input id="signup-phone" class="form-control"
                                           placeholder="Número celular ó fijo"
                                           name="phone" type="text" maxlength="10" />
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input id="terms" type="checkbox"/>
                                            <span class="clr-etb-orange">Acepto los términos y condiciones del
                                            servicio,
                                                <a href="{{url('terminos_y_condiciones.pdf')}}" target="_blank">
                                                    conoce más información aquí.
                                                </a>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button id="btn-signup-etb" class="btn btn-opts">Regístrarme</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <p class="signup">¿Ya estás registrado? &nbsp;
                    <a href="{{url('ingresar')}}">Ingresa aquí</a></p>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
@stop
