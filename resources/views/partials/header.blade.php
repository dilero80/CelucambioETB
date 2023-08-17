<header class="etb main-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed"
                                    data-toggle="collapse"
                                    data-target="#navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="{{url('/')}}">
                                <img src="{{url('images/etb_logo.png')}}" alt="ETB"/>
                            </a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                @if (Auth::guard('customer')->check())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle"
                                       data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        {{Auth::guard('customer')->user()->name}}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('usuario/dashboard')}}">Mi Historial</a></li>
                                        <li><a href="{{url('logout')}}">Cerrar sesión</a></li>
                                    </ul>
                                </li>
                                @else
                                <li>
                                    <a href="{{url('ingresar')}}">
                                       Ingresar
                                    </a>
                                </li>
                                <li>
                                    <a class="bordered" href="{{url('registro')}}">
                                       Regístrate gratis
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </div>
        </div>
    </div>
</header>
