@extends('layouts.default')

@section('content')
<section class="etb auth">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-wrapper">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="top">
                            <a href="{{url('/')}}">
                                <img src="{{url('images/etb_logo.png')}}" alt="ETB"/>
                            </a>
                        </div>
                        <div class="bottom">
                            <div class="form-group">
                                <h1>
                                    Cambiar
                                    <small>contraseña</small>
                                </h1>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control"
                                       placeholder="Tu correo"
                                       name="email" value="{{ $email or old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control"
                                       name="password" placeholder="Tu nueva contraseña">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" placeholder="Confirma tu nueva contraseña">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-opts">Continuar</button>
                            </div>
                        </div>
                    </form>
                </div>
             </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
@stop
