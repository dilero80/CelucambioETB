(function($, window) {
  //Create steps tabs
  $('#exchange-steps a').click(function (e) {
    e.preventDefault();

    if (this.href.indexOf('your-new-smartphone') != -1) {
      cleanDevices();
    }

    if (this.href.indexOf('book-and-confirm') != -1) {
      updateSellSummary();
    }

    $(this).tab('show');
  });
  //shared on steps
  var order = {};
  var devices = {};
  var currentDevice = {offer: 0};

  function cleanDevices() {
    devices = {};
  }

  function getDeviceById(id, brand) {
    var items = devices[brand];
    var device = {};
    for (var i = 0; i < items.length; i++) {
      if (items[i].id == id) {
        device = items[i];
        break;
      }
    }

    return device;
  }

  function fetchDevicesNames(id, callback) {
    utils.fetchData({
      url: '/brand/'+id+'/devices/names/',
      onSuccess: function(res) {
        if (res.success) {
          devices[id] = res.data;
          callback();
        }
      }
    });
  }

  function fetchDevicesInBrand(id, callback) {
    utils.fetchData({
      url: '/brand/'+id+'/devices/all/',
      onSuccess: function(res) {
        if (res.success) {
          devices[id] = res.data;
          callback();
        }
      }
    });
  }

  function fetchDeviceDetails(id, callback) {
    utils.fetchData({
      url: '/device/'+id+'/details/',
      onSuccess: function(res) {
        if (res.success) {
          devices[id] = res.data;
          callback(res.data);
        }
      }
    });
  }

  //step 1
  var brandSelectUsed = $('#brand-select-used');
  var deviceSelect = $('#device-select-used');
  var states = ['Defectuoso', 'Aceptable', 'Bueno', 'Excelente'];
  var tmplDefective = '<li>No prende</li>'+
      '<li>Posee daño de software</li>'+
      '<li>Su apariencia es levemente usado</li>'+
      '<li>Pantalla con rayones o quebrada</li>';
  var tmplAceptable = '<li>Funciona perfectamente</li>'+
      '<li>Puede presentar signos de uso mayores</li>'+
      '<li>Presenta rayones notorios o profundos</li>'+
      '<li>Pantalla rota o quebrada</li>'+
      '<li>Carcaza rota o quebrada</li>';
  var tmplGood = '<li>Funciona perfectamente</li>'+
      '<li>Puede presentar signos de uso menores</li>'+
      '<li>Los rayones no son profundos</li>'+
      '<li>Presenta golpes o peladuras leves</li>'+
      '<li>No puede estar rota la pantalla ni la carcaza</li>';
  var tmplExcelent = '<li>Funciona perfectamente</li>'+
      '<li>Posee cargador original</li>'+
      '<li>Su apariencia es casi como nuevo</li>'+
      '<li>No tiene golpes ni peladuras</li>'+
      '<li>Pantalla sin rayones ni polvo</li>';

  function getMainImage(media) {
    var path = '/';

    media.forEach(function(item) {
      if (item.is_main == 1) {
        path += item.src;
      }
    });

    return path;
  }

  function updateDeviceSelect(data) {
    var tmpl = '<option value="">Selecciona el equipo</option>';
    data.forEach(function(item) {
      tmpl += '<option value="'+item.id+'">'+item.name+'</option>';
    });

    deviceSelect.html(tmpl).removeAttr('disabled');
  }

  function updateDeviceImg(img) {
    $('.device-viewer img').attr('src', img);
  }

  function updatePriceOffer(price) {
    $('.device-offer .amount').html(numeral(price).format('$0,0'));
  }

  function restoreStep1Form() {
    brandSelectUsed.val(brandSelectUsed.find('option:first').val());
    deviceSelect
      .html('<option value="">Selecciona el equipo</option>')
      .attr('disabled', 'disabled');
    $('#state-slider').slider('option', 'disabled', true);
    updateDeviceImg('/images/default_phone.png');
    updatePriceOffer('0');
  }

  function getDeviceOffer(device, state) {
    var offer = 0;

    switch(state) {
    case 3:
      offer = Number(device.inventory.receive_excelent);
      break;
    case 2:
      offer = Number(device.inventory.receive_good);
      break;
    case 1:
      offer = Number(device.inventory.receive_aceptable);
      break;
    case 0:
      offer = Number(device.inventory.receive_defective);
      break;
    }

    return offer;
  }

  brandSelectUsed.on('change', function() {
    var id = $(this).val();

    if (id) {
      deviceSelect.attr('disabled', 'disabled');
      if (devices.hasOwnProperty(id)) {
        updateDeviceSelect(devices[id]);
      }else{
        deviceSelect.html('<option value="">Cargando...</option>');
        fetchDevicesNames(id, function() {
          updateDeviceSelect(devices[id]);
        });
      }
    }else{
      restoreStep1Form();
    }
  });

  deviceSelect.on('change', function() {
    var id = $(this).val();

    if (id) {
      updateDeviceImg('/images/loader.gif');
      fetchDeviceDetails(id, function(device) {
        currentDevice = device;
        updateDeviceImg(getMainImage(device.media));
        var offer = getDeviceOffer(currentDevice, $('#state-slider').slider('option', 'value'));
        updatePriceOffer(offer);
      });

      $('#state-slider').slider('option', 'disabled', false);
    }else{
      $('#state-slider').slider('option', 'disabled', true);
      updateDeviceImg('/images/default_phone.png');
      updatePriceOffer('0');
    }
  });

  function updateStateDescription(state, tmpl) {
    $('.device-state-widget .state').html(state);
    $('.device-state-widget .desc-list').html(tmpl);
  }

  function updateStateDescription(state, tmpl) {
    $('.device-state-widget .state').html(state);
    $('.device-state-widget .desc-list').html(tmpl);
  }

  $('#state-slider').slider({
    disabled: true,
    min: 0,
    max: states.length-1,
    step: 1,
    value: 3,
    change: function(event, ui) {
      switch(ui.value) {
      case 0:
        updateStateDescription(states[0], tmplDefective);
        updatePriceOffer(currentDevice.inventory.receive_defective);
        break;
      case 1:
        updateStateDescription(states[1], tmplAceptable);
        updatePriceOffer(currentDevice.inventory.receive_aceptable);
        break;
      case 2:
        updateStateDescription(states[2], tmplGood);
        updatePriceOffer(currentDevice.inventory.receive_good);
        break;
      case 3:
        updateStateDescription(states[3], tmplExcelent);
        updatePriceOffer(currentDevice.inventory.receive_excelent);
        break;
      }
    }
  })
  .slider('pips', {
    rest: 'label',
    labels: states
  });

  $('#send-step1').click(function(e) {
    e.preventDefault();
    var data = utils.getJsonFormData('#exchange-step1');

    if (utils.isDataEmpty(data)) {
      humane.error = humane.spawn({
        addnCls: 'humane-flatty-error',
        timeout: 2000
      });
      humane.error('¡Hay datos incompletos!');
    } else{
      order.device_used_id = deviceSelect.val();
      order.device_used_state = $('#state-slider').slider('option', 'value');
      currentDevice.offer = getDeviceOffer(currentDevice, order.device_used_state);
      cleanDevices();
      $('#exchange-steps a[href="#your-new-smartphone"]').tab('show');
    }
  });
  //step 2
  var brandDevices = {};
  var brandSelectNew = $('#brand-select-new');
  var devicesList = $('.devices-list');

  function getCurrentSelectedState() {
    var item = $('div.customer-select-state .selected');
    return item.attr('data-state');
  }

  function filterByInventory(state, items, callback) {
    var filtered = [];

    items.forEach(function(item) {
      if (item.inventory != null) {
        if (state == 1) {
          if (item.inventory.sell_new > currentDevice.offer && item.inventory.stock_new > 0) {
            filtered.push(item);
          }
        }else {
          if (item.inventory.sell_affordable > currentDevice.offer && item.inventory.stock_used > 0) {
            filtered.push(item);
          }
        }
      }
    });

    callback(state, filtered);
  }

  function selectDeviceFromModal(e) {
    e.preventDefault();
    var id = $('#device-basic-information').attr('data-id');
    var device = getDeviceById(id, brandSelectNew.val());
    var state = getCurrentSelectedState();

    if (device.hasOwnProperty('id')) {
      order.device_new_id = device.id;
      order.device_new_state = state;
      $('#device-detail-modal').modal('hide');
      var item = getDeviceById(order.device_new_id, brandSelectNew.val());
      updateNewDevice(item.name);
      $('#exchange-steps a[href="#your-plan"]').tab('show');
    }
  }

  function getPhoneMediaComponent(media) {
    var tmpl = '<div id="device-detail-media">';

    media.forEach(function(item) {
      if (item.is_main == 1) {
        tmpl += '<div class="main-img">'+
          '<img class="img-responsive" src="/'+item.src+'">'+
          '</div>';
      }
    });

    tmpl += '<div class="thumbs-preview">';

    media.forEach(function(item) {
      if (item.is_main == 1) {
        tmpl += '<div class="thumb active">'+
          '<img class="img-responsive" src="/'+item.src+'">'+
          '</div>';
      }else{
        tmpl += '<div class="thumb">'+
          '<img class="img-responsive" src="/'+item.src+'">'+
          '</div>';
      }
    });

    tmpl += '</div></div>';

    return tmpl;
  }

  function updateDeviceModal(data) {
    var state = getCurrentSelectedState();
    var tmpl = ''+
        '<div class="row visible-xs-block">'+
          getPhoneMediaComponent(data.media)+
          '<div id="device-basic-information" data-id="'+data.id+'">'+
            '<div class="item-information">'+
              '<div>'+
                '<div>'+data.system+'</div>'+
                '<label>Sistema</label>'+
              '</div>'+
            '</div>'+
            '<div class="item-information">'+
              '<div>'+
                '<div>'+data.network+'</div>'+
                '<label>Red</label>'+
              '</div>'+
            '</div>'+
            '<div class="item-information">'+
              '<div>'+
                '<div>'+data.camera+'</div>'+
                '<label>Camara</label>'+
              '</div>'+
            '</div>'+
        '</div>';
    if (state == 1) {
      tmpl += '<div id="device-detail-value" data-amount="'+data.inventory.sell_new+'">'+
        numeral(data.inventory.sell_new).format('$0,0')+
        '</div>';
    }else {
      data.inventory.sell_affordable = Number(data.inventory.sell_affordable) + 10000;
      tmpl += '<div id="device-detail-value" data-amount="'+data.inventory.sell_affordable+'">'+
        numeral(data.inventory.sell_affordable).format('$0,0')+
        '</div>';
    }
    tmpl += '<button class="btn btn-action">Seleccionar</button>'+
          '<div id="device-detail-accordion" class="panel-group" '+
                'role="tablist" aria-multiselectable="true">'+
            '<div class="panel panel-default">'+
              '<div class="panel-heading" role="tab" id="headingOne">'+
                '<h4 class="panel-title">'+
                  '<a role="button" data-toggle="collapse" data-parent="#device-detail-accordion" '+
                      'href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">'+
                      'Especificaciones'+
                  '</a>'+
                '</h4>'+
              '</div>'+
              '<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" '+
                  'aria-labelledby="headingOne">'+
                '<div class="panel-body">'+
                  data.specifications+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="panel panel-default">'+
              '<div class="panel-heading" role="tab" id="headingTwo">'+
                '<h4 class="panel-title">'+
                  '<a class="collapsed" role="button" data-toggle="collapse" '+
                      'data-parent="#device-detail-accordion" href="#collapseTwo" aria-expanded="false" '+
                      'aria-controls="collapseTwo">'+
                      'Conectividad'+
                  '</a>'+
                '</h4>'+
              '</div>'+
              '<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" '+
                   'aria-labelledby="headingTwo">'+
                '<div class="panel-body">'+
                  data.conectivity+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="panel panel-default">'+
              '<div class="panel-heading" role="tab" id="headingThree">'+
                '<h4 class="panel-title">'+
                  '<a class="collapsed" role="button" data-toggle="collapse" '+
                     'data-parent="#device-detail-accordion" href="#collapseThree" '+
                     'aria-expanded="false" aria-controls="collapseThree">'+
                    'Multimedia'+
                  '</a>'+
                '</h4>'+
              '</div>'+
              '<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" '+
                    'aria-labelledby="headingThree">'+
                '<div class="panel-body">'+
                  data.multimedia+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="panel panel-default">'+
              '<div class="panel-heading" role="tab" id="headingFour">'+
                '<h4 class="panel-title">'+
                  '<a class="collapsed" role="button" data-toggle="collapse" '+
                     'data-parent="#device-detail-accordion" href="#collapseFour" aria-expanded="false" '+
                     'aria-controls="collapseFour">'+
                    'Mensajería y chat'+
                  '</a>'+
                '</h4>'+
              '</div>'+
              '<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" '+
                  'aria-labelledby="headingFour">'+
                '<div class="panel-body">'+
                  data.messaging+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="panel panel-default">'+
              '<div class="panel-heading" role="tab" id="headingFive">'+
                '<h4 class="panel-title">'+
                  '<a class="collapsed" role="button" data-toggle="collapse" '+
                     'data-parent="#device-detail-accordion" href="#collapseFive" '+
                     'aria-expanded="false" aria-controls="collapseFive">'+
                    'Otros'+
                  '</a>'+
                '</h4>'+
              '</div>'+
              '<div id="collapseFive" class="panel-collapse collapse" '+
                   'role="tabpanel" aria-labelledby="headingFive">'+
                '<div class="panel-body">'+
                  data.others+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
        //Desktop
        '<div class="row">'+
          '<div class="hidden-xs">'+
            '<table>'+
              '<tbody>'+
                '<tr>'+
                  '<td class="left">'+
                    getPhoneMediaComponent(data.media)+
                    '<div id="device-basic-information" data-id="'+data.id+'">'+
                      '<div class="item-information">'+
                        '<div>'+
                          '<div>'+data.system+'</div>'+
                          '<label>Sistema</label>'+
                        '</div>'+
                      '</div>'+
                      '<div class="item-information">'+
                        '<div>'+
                          '<div>'+data.network+'</div>'+
                          '<label>Red</label>'+
                        '</div>'+
                      '</div>'+
                      '<div class="item-information">'+
                        '<div>'+
                          '<div>'+data.camera+'</div>'+
                          '<label>Camara</label>'+
                        '</div>'+
                      '</div>'+
      '</div>';
    if (state == 1) {
      tmpl += '<div id="device-detail-value" data-amount="'+data.inventory.sell_new+'">'+
        numeral(data.inventory.sell_new).format('$0,0')+
        '</div>';
    }else {
      tmpl += '<div id="device-detail-value" data-amount="'+data.inventory.sell_affordable+'">'+
        numeral(data.inventory.sell_affordable).format('$0,0')+
        '</div>';
    }
    tmpl += '<button class="btn btn-action">Seleccionar</button>'+
                  '</td>'+
                  '<td class="right">'+
                    '<div id="device-detail-information">'+
                      '<ul class="nav nav-tabs" role="tablist">'+
                        '<li role="presentation" class="active">'+
                          '<a href="#specifications" aria-controls="specifications" '+
                              'role="tab" data-toggle="tab">'+
                              'Especificaciones'+
                          '</a>'+
                        '</li>'+
                        '<li role="presentation">'+
                          '<a href="#conectivity" role="tab" data-toggle="tab">'+
                            'Conectividad'+
                          '</a>'+
                        '</li>'+
                        '<li role="presentation">'+
                          '<a href="#multimedia" role="tab" data-toggle="tab">'+
                            'Multimedia'+
                          '</a>'+
                        '</li>'+
                        '<li role="presentation">'+
                          '<a href="#messaging" role="tab" data-toggle="tab">'+
                            'Mensajería y chat'+
                          '</a>'+
                        '</li>'+
                        '<li role="presentation">'+
                          '<a href="#others" role="tab" data-toggle="tab">'+
                            'Otros'+
                          '</a>'+
                        '</li>'+
                      '</ul>'+
                      '<div class="tab-content">'+
                        '<div role="tabpanel" class="tab-pane fade in active" id="specifications">'+
                          data.specifications+
                        '</div>'+
                        '<div role="tabpanel" class="tab-pane fade" id="conectivity">'+
                          data.conectivity+
                        '</div>'+
                        '<div role="tabpanel" class="tab-pane fade" id="multimedia">'+
                          data.multimedia+
                        '</div>'+
                        '<div role="tabpanel" class="tab-pane fade" id="messaging">'+
                          data.messaging+
                        '</div>'+
                        '<div role="tabpanel" class="tab-pane fade" id="others">'+
                          data.others+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                  '</td>'+
                '</tr>'+
              '</tbody>'+
            '</table>'+
          '</div>'+
        '</div>';

    $('#device-detail-modal .modal-title').html(data.name);
    $('#device-detail-modal .modal-body').html(tmpl);
    $('#device-detail-information a').click(function(e) {
      e.preventDefault();
      $(this).tab('show');
    });

    $('#device-detail-modal .btn-action').off().on('click', selectDeviceFromModal);

    $('#device-detail-media .thumb').click(function() {
      $('#device-detail-media .thumb').removeClass('active');
      $(this).addClass('active');
      var img = $(this).find('img');
      $('#device-detail-media .main-img').find('img').attr('src', img.attr('src'));
    });
  }

  function selectDevice(e) {
    e.preventDefault();
    var parent = $(this).parent();
    var id = parent.attr('data-item');
    var device = getDeviceById(id, brandSelectNew.val());
    var state = getCurrentSelectedState();

    if (device.hasOwnProperty('id')) {
      order.device_new_id = device.id;
      order.device_new_state = state;
      var item = getDeviceById(order.device_new_id, brandSelectNew.val());
      updateNewDevice(item.name);

      $('#exchange-steps a[href="#your-plan"]').tab('show');
    }
  }

  function updateBrandDevicesTmpl(state, items) {
    if (items.length) {
       var tmpl = '';

      items.forEach(function(item) {
        tmpl += '<div class="device-item" data-item="'+item.id+'">'+
          '<div class="image">'+
          '<div class="overlay-more">'+
          '<span class="glyphicon glyphicon-zoom-in" '+
          'aria-hidden="true"></span>'+
          '</div>'+
          '<img class="img-responsive" src="'+getMainImage(item.media)+'"/>'+
          '</div>'+
          '<div class="view-details">Ver detalles</div>'+
          '<div class="name">'+item.name+'</div>'+
          '<div class="line-deco"></div>';
        if (state == 1) {
          tmpl += '<div class="price">Valor '+
            '<span class="amount">'+
              numeral(item.inventory.sell_new).format('$0,0')
            +'</span>'+
          '</div>'+
          '<div class="price-discount">Paga Solo '+
            '<span class="amount">'+
            numeral(utils.calcDifference(item.inventory.sell_new, currentDevice.offer))
            .format('$0,0')
            +'</span>'+
            '</div>';
        }else{
          item.inventory.sell_affordable = Number(item.inventory.sell_affordable)+10000;

          tmpl += '<div class="price">Valor '+
            '<span class="amount">'+
            numeral(item.inventory.sell_affordable).format('$0,0')
              +'</span>'+
            '</div>'+
            '<div class="price-discount">Paga Solo '+
            '<span class="amount">'+
            numeral(utils.calcDifference(item.inventory.sell_affordable, currentDevice.offer))
            .format('$0,0')
            +'</span>'+
            '</div>';
        }

        tmpl += '<button class="btn btn-action">Seleccionar</button>'+
          '</div>';
      });
      devicesList.html(tmpl);
      var detailModal = $('#device-detail-modal');

      $('div.device-item .overlay-more').off().on('click', function() {
        var id = $(this).parent().parent().attr('data-item');
        detailModal.find('.modal-title').html('');
        detailModal.find('.modal-body').html('<div id="loading-wrapper">'+
                                             '<div class="spinner">'+
                                             '<div class="rect1"></div>'+
                                             '<div class="rect2"></div>'+
                                             '<div class="rect3"></div>'+
                                             '<div class="rect4"></div>'+
                                             '<div class="rect5"></div>'+
                                             '</div>'+
                                             '<p>Cargando...</p>'+
                                             '</div>');
        detailModal.modal();
        updateDeviceModal(getDeviceById(id, brandSelectNew.val()));
      });

      $('div.device-item .view-details').off().on('click', function() {
        var id = $(this).parent().attr('data-item');
        detailModal.find('.modal-title').html('');
        detailModal.find('.modal-body').html('<div id="loading-wrapper">'+
                                             '<div class="spinner">'+
                                             '<div class="rect1"></div>'+
                                             '<div class="rect2"></div>'+
                                             '<div class="rect3"></div>'+
                                             '<div class="rect4"></div>'+
                                             '<div class="rect5"></div>'+
                                             '</div>'+
                                             '<p>Cargando...</p>'+
                                             '</div>');
        detailModal.modal();
        updateDeviceModal(getDeviceById(id, brandSelectNew.val()));
      });

      $('div.device-item .btn-action').off().on('click', selectDevice);
    } else {
      devicesList.html('<p>No hay datos de equipos</p>');
    }
  }

  function updateDevicesList(state, brandId) {
    var unfiltered = devices[brandId];
    filterByInventory(state, unfiltered, updateBrandDevicesTmpl);
  }

  function restoreStep2Form() {
    brandSelectNew.val(brandSelectNew.find('option:first').val());
    devicesList.html('<p>Escoge la marca para cargar los equipos disponibles.</p>');
  }

  brandSelectNew.on('change', function() {
    var id = $(this).val();

    if (id) {
      devicesList.html('<div id="loading-wrapper">'+
                       '<div class="spinner">'+
                       '<div class="rect1"></div>'+
                       '<div class="rect2"></div>'+
                       '<div class="rect3"></div>'+
                       '<div class="rect4"></div>'+
                       '<div class="rect5"></div>'+
                       '</div>'+
                       '<p>Cargando...</p>'+
                       '</div>');
      if (devices.hasOwnProperty(id)) {
        updateDevicesList(getCurrentSelectedState(), id);
      }else{
        fetchDevicesInBrand(id, function() {
          updateDevicesList(getCurrentSelectedState(), id);
        });
      }
    }else{
      restoreStep2Form();
    }
  });

  $('.customer-select-state div').click(function() {
    $('.customer-select-state div, .warranty').removeClass('selected');
    var state = $(this).attr('data-state');
    $(this).addClass('selected');
    $('.warranty[data-state="'+state+'"]').addClass('selected');

    if (brandSelectNew.val()) {
      updateDevicesList(state, brandSelectNew.val());
    }
  });

  //step 3
  function updateNewDevice(device) {
    $('.device-offer .new-device').html(device);
  }

  $('.plan-item .btn-action').click(function(e) {
    e.preventDefault();
    var parent = $(this).parent().parent();
    var price = parent.find('.price');
    var name =  parent.find('.name');
    var plan = {
      name: name.text(),
      price: numeral().unformat(price.text()) + '000'
    };
    order.plan = plan;
    updateSellSummary();
    $('#exchange-steps a[href="#book-and-confirm"]').tab('show');
  });

  $('.prepaid-img .btn-action').click(function(e) {
    e.preventDefault();
    var plan = {
      name: 'ETB Prepago',
      price: '0'
    };
    order.plan = plan;
    updateSellSummary();
    $('#exchange-steps a[href="#book-and-confirm"]').tab('show');
  });

  //step 4
  var deliverMinDate = moment().add(2,'days').format("DD-MM-YYYY");

  $('.datepicker').datepicker({
    autoclose: true,
    datesDisabled: ['15/08/2016', '17/10/2016', '7/11/2016', '14/11/2016', '8/12/2016', '25/12/2016'],
    daysOfWeekDisabled: [0,6],
    format: "dd/mm/yyyy",
    language: 'es',
    startDate: deliverMinDate
  });

  function updateSellSummary() {
    var table = $('table.operation');

    if (table.length) {
      var userDevice = currentDevice;
      var newDevice = getDeviceById(order.device_new_id, brandSelectNew.val());
      var userPlan = order.plan;
      var isPospago = false;
      var price = 0;

      //Prepago
      if (userPlan.name == 'ETB Prepago') {
        if (order.device_new_state == 2) {
          price = newDevice.inventory.sell_affordable;
        }else {
          price = newDevice.inventory.sell_new;
        }
      }
      //Pospago
      if (userPlan.name != 'ETB Prepago') {
        isPospago = true;
        if (order.device_new_state == 2) {
          price = Number(newDevice.inventory.sell_affordable) - 10000;
        }else {
          price = newDevice.inventory.sell_plan;
        }
      }

      table.find('.buy-device-name').html(newDevice.name);
      table.find('.buy-device-price').html(numeral(price).format('$0,0'));

      if (isPospago && order.device_new_state == 1) {
        table.find('.plan-name')
          .html(userPlan.name + '<p class="pospago-discount">'+
                '¡Tu smartphone tiene descuento por ser pospago!'+
                '</p>');
      } else {
        table.find('.plan-name').html(userPlan.name);
      }
      table.find('.plan-price').html(numeral(userPlan.price).format('$0,0'));

      table.find('.sell-device-name').html(currentDevice.name);
      table.find('.sell-device-price').html(numeral(currentDevice.offer).format('$0,0'));
      var sum = Number(price) + Number(userPlan.price);
      var result = sum - currentDevice.offer;
      table.find('.result-price').html(numeral(result).format('$0,0'));
    }
  }

  $('#btn-online-etb').click(function(e) {
    e.preventDefault();

    var data = utils.getJsonFormData('#exchange-step4');

    if (utils.isDataEmpty(data)) {
      humane.error = humane.spawn({
        addnCls: 'humane-flatty-error',
        timeout: 2000
      });
      humane.error('¡Hay datos incompletos!');
    } else {
      order.city_id = data.city_id;
      order.delivery_address = data.customer_address;
      order.delivery_date = data.shipment_date;
      order.delivery_time = data.shipment_time;

      utils.sendData({
        url: 'complete-order',
        data: order,
        onSuccess: function(res) {
          if (res.success) {
            window.localStorage.setItem('order_ref', res.data.order_ref);
            window.location.href = res.data.redirect;
          } else {
            humane.error('Se ha producido un error.');
          }
        }
      });
    }
  });

  $('#btn-ondeliver-etb').click(function(e) {
    e.preventDefault();

    var data = utils.getJsonFormData('#exchange-step4');

    if (utils.isDataEmpty(data)) {
      humane.error = humane.spawn({
        addnCls: 'humane-flatty-error',
        timeout: 2000
      });
      humane.error('¡Hay datos incompletos!');
    } else {
      order.city_id = data.city_id;
      order.delivery_address = data.customer_address;
      order.delivery_date = data.shipment_date;
      order.delivery_time = data.shipment_time;
      order.payment_type = 4;

      utils.sendData({
        url: 'complete-order',
        data: order,
        onSuccess: function(res) {
          if (res.success) {
            window.localStorage.setItem('order_ref', res.data.order_ref);
            window.localStorage.setItem('payment_type', 4);
            window.location.href = res.data.redirect;
          } else {
            humane.error('Se ha producido un error.');
          }
        }
      });
    }
  });

})(jQuery, window);
