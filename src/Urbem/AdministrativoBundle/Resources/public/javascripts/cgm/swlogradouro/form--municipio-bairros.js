(function ($, global, urbem) {
  'use strict';

  var fkSwMunicipioField = urbem.giveMeBackMyField('fkSwMunicipio')
    , fkSwMunicipioHField = urbem.giveMeBackMyField('fkSwMunicipioH');

  function setGlobalVarJsFkSwMunicipio(fkSwMunicipo) {
    if (fkSwMunicipo !== undefined && fkSwMunicipo !== "") {
      global.varJsFkSwMunicipio = fkSwMunicipo;
      getAllFkSwBairroFields().select2('disable').select2('enable');
    }
  }

  function getAllFkSwBairroFields() {
    return $(document).find('input[id$="fkSwBairro_autocomplete_input"]');
  }

  if (fkSwMunicipioHField !== undefined) {
    setGlobalVarJsFkSwMunicipio(fkSwMunicipioHField.val());
  } else {
    setGlobalVarJsFkSwMunicipio(fkSwMunicipioField.val());
  }

  fkSwMunicipioField.on('change', function () {
    setGlobalVarJsFkSwMunicipio($(this).val());
  });

  $(document).on('sonata.add_element', function() {
    if (fkSwMunicipioHField !== undefined) {
      setGlobalVarJsFkSwMunicipio(fkSwMunicipioHField.val());
    } else {
      getAllFkSwBairroFields().select2('disable');
      setGlobalVarJsFkSwMunicipio(fkSwMunicipioField.val());
    }
  });
})(jQuery, window, UrbemSonata);
