(function ($, global, urbem) {
  'use strict';

  var fkSwMunicipioFkSwUfField = urbem.giveMeBackMyField('fkSwMunicipio__fkSwUf')
    , fkSwMunicipioField = urbem.giveMeBackMyField('fkSwMunicipio');

  fkSwMunicipioField.select2('disable');

  function setGlobalVarJsCodUf(codUf) {
    if (codUf !== undefined && codUf !== "") {
      global.varJsCodUf = codUf;
      fkSwMunicipioField.select2('enable');
    }
  }

  setGlobalVarJsCodUf(fkSwMunicipioFkSwUfField.val());

  fkSwMunicipioFkSwUfField.on('change', function () {
    setGlobalVarJsCodUf($(this).val());
  });

})(jQuery, window, UrbemSonata);
