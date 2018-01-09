(function ($, global) {
  'use strict';

  var fkSwMunicipioField = $('#filter_fkSwMunicipio_value_autocomplete_input')
    , fkSwMunicipioFkSwUfField = $('#filter_fkSwMunicipio__fkSwUf_value');

  fkSwMunicipioField.select2('disable');

  if (fkSwMunicipioFkSwUfField.val() !== ""
      && fkSwMunicipioFkSwUfField.val() !== undefined) {
    global.varJsCodUf = fkSwMunicipioFkSwUfField.val();
    fkSwMunicipioField.select2('enable');
  }

  fkSwMunicipioFkSwUfField.on('change', function (e) {
    global.varJsCodUf = $(this).val();
    fkSwMunicipioField.select2('enable');
  });

})(jQuery, window);
