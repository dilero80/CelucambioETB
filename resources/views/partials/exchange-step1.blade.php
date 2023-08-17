<div class="container">
    <div class="row">
        <form id="exchange-step1">
            <div class="col-md-5">
                <h1>1. Escoge tu smartphone actual</h1>
                <p>
                    Cuéntanos acerca del Smartphone que quieres vender y conoce el
                    valor que obtienes como parte de pago para tu nuevo Smartphone.
                </p><br>
                <div class="form-group">
                    <select class="form-control" id="brand-select-used" name="brand_id">
                        <option value="">Selecciona la marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="device-select-used"
                            name="id" disabled>
                        <option value="">Selecciona el equipo</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="device-state-widget">
                        <div class="top">
                            <p>Desliza el selector para confirmar el estado de tu smartphone</p>
                            <div class="slider-wrapper">
                                <div id="state-slider" class="slider"></div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="title">Un smartphone
                                <span class="state">excelente</span>
                            </div>
                            <ul class="desc-list">
                                <li>Funciona perfectamente</li>
                                <li>Posee cargador original</li>
                                <li>Su apariencia es casi como nuevo</li>
                                <li>No tiene golpes ni peladuras</li>
                                <li>Pantalla sin rayones ni polvo</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-4">
                <br>
                <div class="form-group">
                    <div class="device-viewer">
                        <img class="img-responsive" src="{{url('images/default_phone.png')}}"/>
                    </div>
                    <div class="device-offer sell-etb">
                        <p>Vende tu smartphone por:</p>
                        <span class="amount">$0</span>
                    </div>
                </div>
                <div class="form-group txt-center">
                    <button id="send-step1" type="submit" class="btn btn-action">
                        Siguiente
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
