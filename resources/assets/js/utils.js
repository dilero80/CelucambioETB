var utils = (function($, window) {
  var self = this;

  function scorePassword(pass) {
    var score = 0;
    if (!pass)
      return score;

    // award every unique letter until 5 repetitions
    var letters = new Object();
    for (var i=0; i<pass.length; i++) {
      letters[pass[i]] = (letters[pass[i]] || 0) + 1;
      score += 5.0 / letters[pass[i]];
    }

    // bonus points for mixing it up
    var variations = {
      digits: /\d/.test(pass),
      lower: /[a-z]/.test(pass),
      upper: /[A-Z]/.test(pass),
      nonWords: /\W/.test(pass)
    };

    variationCount = 0;
    for (var check in variations) {
      variationCount += (variations[check] == true) ? 1 : 0;
    }
    score += (variationCount - 1) * 10;

    return parseInt(score);
  }

  self.enableForm = function(form) {
    $(form).find('select').removeAttr('disabled');
    $(form).find('input').removeAttr('disabled');
  };

  self.setAjaxToken = function() {
    $.ajaxSetup({
      headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
  };

  self.createUploader = function(opts) {
    return new plupload.Uploader({
      runtimes: 'html5, flash, html4',
      flash_sfw_url: '/js/Moxie.swf',
      browse_button: opts.browse_button,
      container: opts.container,
      url: opts.url,
      chunk_size: opts.chunk_size,
      headers: {
        'X-CSRF-Token' : $('meta[name=_token]').attr('content')
      },
      init: {
        PostInit: opts.PostInit,
        FilesAdded: opts.FilesAdded,
        FileUploaded: opts.FileUploaded,
        UploadProgress: opts.UploadProgress,
        UploadComplete: opts.UploadComplete,
        Error: opts.Error
      }
    });
  };

  self.bytesToSize = function(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    if (i == 0) return bytes + ' ' + sizes[i];
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
  };

  self.getJsonFormData = function(form) {
    var formArray = $(form).serializeArray(),
        indexed_data = {};

    $.map(formArray, function(n, i) {
      indexed_data[n['name']] = n['value'];
    });

    return indexed_data;
  };

  self.isDataEmpty = function(obj) {
    for(var prop in obj) {
      if(obj[prop] == "")
        return true;
    }

    return false;
  };

  self.isValidEmail = function(val) {
    var reg = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;

		if (!reg.test(val)) {
			return false;
		}
		return true;
  };

  self.isValidPassword = function(val) {
    var score = scorePassword(val);

    if (score > 54) {
      return true;
    }

    return false;
  };

  self.isValidCard = function(card) {
    if (card.length > 12) {
      return true;
    }

    return false;
  };

  self.isAcceptedInstallment = function(val) {
    var accepted = [1,6,12,24,36];

    accepted.forEach(function(num) {
      if (val !== num) {
        return false;
      }
    });

    return true;
  };

  self.isOnlyText = function(txt) {
    var alphaExp = /^[a-zA-z ]+$/;
    if (txt.match(alphaExp)) {
      return true;
    }

    return false;
  };

  self.fetchData = function(opts) {
    self.setAjaxToken();
    $.ajax({
      type: 'GET',
      url: opts.url
    }).done(function(res) {
      opts.onSuccess(res);
    });
  };

  self.sendData = function(opts) {
    self.setAjaxToken();
    $.ajax({
      type: 'POST',
      url: opts.url,
      data: opts.data
    }).done(function(res) {
      opts.onSuccess(res);
    });
  };

  self.sendMultipartData = function(opts) {
    self.setAjaxToken();
    $.ajax({
      type: 'POST',
      url: opts.url,
      data: opts.data,
      contentType: false,
      processData: false
    }).done(function(res) {
      opts.onSuccess(res);
    });
  };

  self.getCurrentSeller = function() {
    var locationArray = window.location.pathname.split('cambiar');
    return locationArray[0].split('/')[1];
  };

  self.calcDifference = function(price1, price2) {
    return price1 - price2;
  };

  self.showMsg = function(elem) {
    elem.removeClass('hidden');
    setTimeout(function() {
      elem.addClass('hidden');
    }, 3000);
  };

  self.isValidImei = function(imei) {
    if (!/^[0-9]{15}$/.test(imei)) {return false;}

    var sum = 0, factor = 2, checkDigit, multipliedDigit;

    for (var i = 13, li = 0; i >= li; i--) {
      multipliedDigit = parseInt(imei.charAt(i), 10) * factor;
      sum += (multipliedDigit >= 10 ? ((multipliedDigit % 10) + 1) : multipliedDigit);
      (factor === 1 ? factor++ : factor--);
    }
    checkDigit = ((10 - (sum % 10)) % 10);

    return !(checkDigit !== parseInt(imei.charAt(14), 10));
  };

  return self;
}(jQuery, window));
