<div class="container">
    <form id="exchange-step2">
        <div class="row">
            <div class="col-md-5">
                <h1>2. Escoge tu nuevo smartphone</h1>
                <p>
                    Selecciona el Smartphone que más te guste. El valor de tu teléfono
                    será descontado para que solo pagues la diferencia.
                </p>
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
                            de saldo disponible</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Selecciona la marca:</label>

                    <select class="form-control" id="brand-select-new">
                        <option value="">Selecciona la marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Selecciona el estado:</label>
                    <div class="customer-select-state">
                        <div data-state="1" class="new selected">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            Nuevo*
                        </div>
                        <div data-state="2" class="affordable">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            Usado como nuevo*
                        </div>
                    </div>
                    <p data-state="1" class="warranty selected">* Incluye garantía de 12 meses</p>
                    <p data-state="2" class="warranty pull-right">* Incluye garantía de 3 meses</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="devices-list col-md-12">
                <p>Escoge la marca para cargar los equipos disponibles.</p>
            </div>
        </div>
    </form>
</div>
