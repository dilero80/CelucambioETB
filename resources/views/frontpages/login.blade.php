@extends('layouts.default')

@section('content')
<section class="etb auth">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-wrapper">
                    <form id="login-etb" role="form">
                        <div class="top">
                            <a href="{{url('/')}}">
                                <img src="{{url('images/etb_logo.png')}}" alt="Celucambio"/>
                            </a>
                        </div>
                        <div class="bottom">
                            <div class="form-group">
                                <h1>
                                    Ingresa
                                    <small>a tu cuenta</small>
                                </h1>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email"
                                       name="email" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Contraseña"
                                       name="password" type="password"/>
                            </div>
                            <div class="form-group">
                                <a href="{{url('recuperar-cuenta')}}" class="clr-etb-orange">
                                    Olvidé mi contraseña
                                </a>
                            </div>
                            <div class="form-group">
                                <button id="btn-login" class="btn btn-opts">Iniciar sesión</button>
                            </div>
                        </div>
                    </form>
                </div>
                <p class="signup">¿No te has registrado todavia? &nbsp;
                    <a href="{{url('registro')}}">Regístrate</a></p>
             </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
@stop
