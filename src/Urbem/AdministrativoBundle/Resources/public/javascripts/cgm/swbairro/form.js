(function ($, global, urbem) {
  'use strict';

  var fkSwUfField = urbem.giveMeBackMyField('fkSwUf')
    , fkSwMunicipioField = urbem.giveMeBackMyField('fkSwMunicipio');

  fkSwMunicipioField.select2('disable');

  if (fkSwUfField.val() !== undefined && fkSwUfField.val() !== '') {
    global.varJsCodUf = fkSwUfField.val();
    fkSwMunicipioField.select2('enable');
  }

  fkSwUfField.on('change', function () {
    global.varJsCodUf = $(this).val();
    fkSwMunicipioField.select2('enable');
  });

})(jQuery, window, UrbemSonata);
