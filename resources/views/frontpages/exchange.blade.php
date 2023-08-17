@extends('layouts.default')

@section('content')
@include('partials.header')
<section class="page">
    <div id="exchange-steps">
        <!-- Steps tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#your-used-smartphone"
                   aria-controls="Selecciona tu smartphone actual"
                   role="tab" data-toggle="tab">1. Escoge tu smartphone actual</a>
            </li>
            <li role="presentation">
                <a href="#your-new-smartphone"
                   aria-controls="Escoge tu nuevo smartphone"
                   role="tab" data-toggle="tab">2. Escoge tu nuevo smartphone</a>
            </li>
            <li role="presentation">
                <a href="#your-plan"
                   aria-controls="Escoge tu plan"
                   role="tab" data-toggle="tab">3. Escoge tu plan</a>
            </li>
            <li role="presentation">
                <a href="#book-and-confirm"
                   aria-controls="Agenda y confirma"
                   role="tab" data-toggle="tab">4. Agenda y confirma</a>
            </li>
        </ul>
        <!-- Steps tabs panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="your-used-smartphone">
                @include('partials.exchange-step1')
            </div>
            <div role="tabpanel" class="tab-pane" id="your-new-smartphone">
                 @include('partials.exchange-step2')
            </div>
            <div role="tabpanel" class="tab-pane" id="your-plan">
                 @include('partials.exchange-step3')
            </div>
            <div role="tabpanel" class="tab-pane" id="book-and-confirm">
                 @include('partials.exchange-step4')
            </div>
        </div>
    </div>
    <!--detail device modal-->
    <div id="device-detail-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="loading-wrapper">
                        <div class="spinner">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                        <p>Cargando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
