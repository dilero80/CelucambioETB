@extends('layouts.default')

@section('content')
<section class="etb auth">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-wrapper">
                    <form id="recoverpass-etb" role="form">
                        <div class="top">
                            <a href="{{url('/')}}">
                                <img src="{{url('images/etb_logo.png')}}" alt="Celucambio"/>
                            </a>
                        </div>
                        <div class="bottom">
                            <div class="form-group">
                                <h1>
                                    Recupera
                                    <small> tu contraseña</small>
                                </h1>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Tu Email"
                                       name="email" type="text"/>
                            </div>
                            <div class="form-group">
                                <button id="btn-recoverpass" class="btn btn-opts">Enviar correo</button>
                            </div>
                        </div>
                    </form>
                </div>
               <p class="signup">¿Ya te acordaste? &nbsp;
                    <a href="{{url('ingresar')}}">Ingresa</a></p>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
@stop
