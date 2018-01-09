(function () {
  'use strict';

  var mostraPlacasRadionButtons = $('.placa-identificacao input[type="radio"]')
    , onlyAlphaFields = $('.only-alpha')
    , onlyNumberFields = $('.only-number')
    , numericOnly = function (event) {
      var regex = new RegExp("^[0-9\b]+$")
        , key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      
      if (!regex.test(key)) {
         event.preventDefault();
         return false;
      }
    }
    , alphaOnly = function (event) {
      var regex = new RegExp("^[a-zA-Z0-9\b]+$")
        , key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      
      if (!regex.test(key)) {
        event.preventDefault();
        return false;
      }
    };

  onlyAlphaFields.bind('keypress', alphaOnly);
  onlyNumberFields.bind('keypress', numericOnly);

  mostraPlacasRadionButtons.on('ifChecked', function(event) {
    var hideNumeroPlacaField = $(this).val() == 0 ? true : false
      , ids = $(this).attr('id').split('_')
      , sAdmin = ids[1]
      , nElem = ids[2]
      , numeroPlacaField = UrbemSonata.giveMeBackMyField(sAdmin + '_' + nElem + '_numeroPlaca')
      , numeroPlacaContainer = $('#sonata-ba-field-container-' + numeroPlacaField.attr('id'))
    ;
    
    if (true === hideNumeroPlacaField && true === numeroPlacaContainer.is(':visible')) {
      numeroPlacaContainer.hide();
    } else if (false === numeroPlacaContainer.is(':visible')) {
      numeroPlacaContainer.show();
    }
  });

  // console.log(mostraPlacasRadionButtons);
}());
