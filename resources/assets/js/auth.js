(function($, window) {
  //Login
  $('#btn-login').click(function(e) {
    e.preventDefault();
    var data = utils.getJsonFormData('#login-etb');


    humane.error = humane.spawn({
      addnCls: 'humane-flatty-error',
      timeout: 2000
    });

    if (utils.isDataEmpty(data)) {
      humane.error('Hay campos vacios.');
    } else if (!utils.isValidEmail(data.email)) {
      humane.error('El correo ingresado no es válido.');
    } else {

      if (window.localStorage.getItem('order_ref') !== null) {
        data.order = window.localStorage.getItem('order_ref');
      }

      if (window.localStorage.getItem('payment_type') !== null) {
        data.payment_type = window.localStorage.getItem('payment_type');
      }

      utils.setAjaxToken();
      utils.sendData({
        url: 'login',
        data: data,
        onSuccess: function(res) {
          if (res.success) {
            window.localStorage.removeItem('order_ref');
            window.localStorage.removeItem('payment_type');
            window.location.href = res.data;
          } else {
            humane.error(res.err);
          }
        }
      });
    }
  });

  //Register
  var signupId = document.getElementById('signup-identification');
  var signupPhone = document.getElementById('signup-phone');

  if (signupId) {
    inputTypeNumberPolyfill.polyfillElement(signupId);
  }

  if (signupPhone) {
    inputTypeNumberPolyfill.polyfillElement(signupPhone);
  }

  function updateLeftToIdentificationTxt(txt) {
    $('#signup-etb .input-group-addon').html(txt);
  }

  $('select#type-id').on('change', function() {
    var id = $(this).val();
    if (id) {
      if (id == 1) {
        updateLeftToIdentificationTxt('C.C');
      }
      if (id == 2) {
        updateLeftToIdentificationTxt('C.E.');
      }
    } else {
      updateLeftToIdentificationTxt('-');
    }
  });

  $('#btn-signup-etb').click(function(e) {
    e.preventDefault();

    var data = utils.getJsonFormData('#signup-etb');
    humane.error = humane.spawn({
      addnCls: 'humane-flatty-error',
      timeout: 2000
    });

    if (utils.isDataEmpty(data)) {
      humane.error('Hay campos vacios.');
    } else if (!utils.isValidEmail(data.email)) {
      humane.error('El correo ingresado no es válido.');
    } else if (data.password !== data.password_repeat) {
      humane.error('Las contraseñas no coinciden.');
    } else if (!utils.isValidPassword(data.password)) {
      humane
        .error('Contraseña no válida, debe tener mínimo 8 caracteres y contener numeros, letras y símbolos.');
    } else if (!$('#terms').is(':checked')) {
      humane.error('Debes aceptar los términos y condiciones.');
    } else {
      if (window.localStorage.getItem('order_ref') !== null) {
        data.order = window.localStorage.getItem('order_ref');
      }

      utils.setAjaxToken();
      utils.sendData({
        url: 'signup',
        data: data,
        onSuccess: function(res) {
          if (res.success) {
            window.localStorage.removeItem('order_ref');
            window.location.href = res.data;
          } else {
            res.data.forEach(function(err) {
              humane.error(err);
            });
          }
        }
      });
    }
  });

})(jQuery, window);
