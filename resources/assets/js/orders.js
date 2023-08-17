(function($, window) {
  //Payment
  var etbImei = document.getElementById('etb-imei');
  var etbPayerPhone = document.getElementById('etb-payer-phone');
  var etbCardNumber = document.getElementById('etb-card-number');
  var etbCardCode = document.getElementById('etb-card-code');

  if (etbImei) {
    inputTypeNumberPolyfill.polyfillElement(etbImei);
  }

  if (etbPayerPhone) {
    inputTypeNumberPolyfill.polyfillElement(etbPayerPhone);
  }

  if (etbCardNumber) {
    inputTypeNumberPolyfill.polyfillElement(etbCardNumber);
  }

  if (etbCardCode) {
    inputTypeNumberPolyfill.polyfillElement(etbCardCode);
  }

  function getOrder() {
    var url = window.location.href;
    return url.split('checkout/')[1];
  }

  function getDeliverOrder() {
    var url = window.location.href;
    return url.split('contraentrega/')[1];
  }

  $('#btn-etb-creditcard').click(function(e) {
    e.preventDefault();
    humane.error = humane.spawn({
      addnCls: 'humane-flatty-error',
      timeout: 2000
    });
    var data = utils.getJsonFormData('#form-etb-payment');
    delete data.bank;
    delete data.payer_dni;
    delete data.payer_name_account;
    delete data.payer_person_type;
    delete data.payer_pse_phone;

    if (utils.isDataEmpty(data) ) {
      humane.error('Hay datos vacios por favor llene todos los campos');
    } else if (!data.hasOwnProperty('payment_method')) {
      humane.error('No has seleccionado el método de pago');
    } else if (!utils.isValidImei(String(data.user_imei))) {
      humane.error('El Imei ingresado no es válido');
    } else if (!utils.isValidEmail(data.payer_email)) {
      humane.error('Ingresa un correo válido');
    } else if (!utils.isValidCard(data.card_number)) {
      humane.error('El número de tarjeta no es válido');
    } else if (data.card_type === 'CODENSA') {
      if (!utils.isAcceptedInstallment(data.installments)) {
        humane.error('Con codensa sólo puedes pagar a 1,6,12,24 ó 36 cuotas');
      }
    } else if (!$('#terms-check-creditcard').is(':checked')) {
      humane.error('Debes aceptar los términos y condiciones para continuar');
    } else {
      var loader = $('#credit-card-loading');
      data.order = getOrder();
      data.payment_type = 'credit_card';
      loader.removeClass('hidden');

      utils.setAjaxToken();
      utils.sendData({
        url: '/usuario/processpayu',
        data: data,
        onSuccess: function(res) {
          if (res.success) {
            window.location.href = res.data.redirect;
          } else {
            loader.addClass('hidden');
            humane.error(res.data.message);
          }
        }
      });
    }
  });

  $('#btn-etb-cash').click(function(e) {
    e.preventDefault();
    humane.error = humane.spawn({
      addnCls: 'humane-flatty-error',
      timeout: 2000
    });
    var data = utils.getJsonFormData('#form-etb-payment');

    if (data.user_imei == '') {
      humane.error('Hay datos vacios por favor llene todos los campos');
    } else if (!data.hasOwnProperty('payment_method')) {
      humane.error('No has seleccionado el método de pago');
    } else if (!utils.isValidImei(String(data.user_imei))) {
      humane.error('El Imei ingresado no es válido');
    } else if (!$('#terms-check-cash').is(':checked')) {
      humane.error('Debes aceptar los términos y condiciones para continuar');
    } else {
      var loader = $('#cash-loading');
      data.order = getOrder();
      data.payment_type = 'baloto_efecty';
      loader.removeClass('hidden');

      utils.setAjaxToken();
      utils.sendData({
        url: '/usuario/processpayu',
        data: data,
        onSuccess: function(res) {
          if (res.success) {
            window.location.href = res.data.redirect;
          } else {
            loader.addClass('hidden');
            humane.error(res.data.message);
          }
        }
      });
    }
  });

  $('#btn-etb-pse').click(function(e) {
    e.preventDefault();
    humane.error = humane.spawn({
      addnCls: 'humane-flatty-error',
      timeout: 2000
    });
    var data = utils.getJsonFormData('#form-etb-payment');

    if (data.user_imei == '') {
      humane.error('Hay datos vacios por favor llene todos los campos');
    } else if (!data.hasOwnProperty('payment_method')) {
      humane.error('No has seleccionado el método de pago');
    } else if (!utils.isValidImei(String(data.user_imei))) {
      humane.error('El Imei ingresado no es válido');
    } else if (!$('#terms-check-pse').is(':checked')) {
      humane.error('Debes aceptar los términos y condiciones para continuar');
    } else {
      var loader = $('#pse-loading');
      data.order = getOrder();
      data.payment_type = 'pse';
      loader.removeClass('hidden');

      utils.setAjaxToken();
      utils.sendData({
        url: '/usuario/processpayu',
        data: data,
        onSuccess: function(res) {
          if (res.success) {
            window.location.href = res.data.redirect;
          } else {
            loader.addClass('hidden');
            humane.error(res.data.message);
          }
        }
      });
    }
  });

  $('#btn-finish-ondeliver').click(function(e) {
    e.preventDefault();
    humane.error = humane.spawn({
      addnCls: 'humane-flatty-error',
      timeout: 2000
    });

    var data = utils.getJsonFormData('#form-etb-ondeliver');

    if (utils.isDataEmpty(data) ) {
      humane.error('Hay datos vacios por favor llene todos los campos');
    } else if (!utils.isValidImei(String(data.user_imei))) {
      humane.error('El Imei ingresado no es válido');
    } else if (!utils.isValidEmail(data.customer_email)) {
      humane.error('Ingresa un correo válido');
    }  else if (!$('#terms-check-ondeliver').is(':checked')) {
      humane.error('Debes aceptar los términos y condiciones para continuar');
    } else {
      var loader = $('#ondeliver-loading');
      data.order = getDeliverOrder();
      loader.removeClass('hidden');

      utils.sendData({
        url: '/usuario/processondeliver',
        data: data,
        onSuccess: function(res) {
          if (res.success) {
            window.location.href = res.data.redirect;
          } else {
            loader.addClass('hidden');
            humane.error(res.data);
          }
        }
      });
    }
  });

})(jQuery, window);
