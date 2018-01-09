(function ($, global, urbem) {
  'use strict';

  global.varJsCodPais = 0;
  global.varJsCodPaisCorresp = 0;

  var fieldFkSwPais = urbem.giveMeBackMyField('fkSwCgm__fkSwPais')
    , fieldFkSwPaisCorresp = urbem.giveMeBackMyField('fkSwPais1')
    , fieldSwLogradouro = urbem.giveMeBackMyField('swLogradouro')
    , fieldSwLogradouroCorresp = urbem.giveMeBackMyField('swLogradouroCorresp');

  function setVarJsCodPais(codPais) {
    if (codPais !== "" || codPais !== undefined) {
      global.varJsCodPais = codPais;
      fieldSwLogradouro.select2('enable');
    }
  }

  function setVarJsCodPaisCorresp(codPaisCorresp) {
    if (codPaisCorresp !== "" || codPaisCorresp !== undefined) {
      global.varJsCodPaisCorresp = codPaisCorresp;
      fieldSwLogradouroCorresp.select2('enable');
    }
  }

  $(document).ready(function () {
    if (fieldFkSwPais.attr('disabled') === undefined) {
      setVarJsCodPais(fieldFkSwPais.val());
    }

    if (fieldFkSwPaisCorresp.attr('disabled') === undefined) {
      setVarJsCodPaisCorresp(fieldFkSwPaisCorresp.val());
    }

  });

  fieldFkSwPais.on('change', function (e) {
    setVarJsCodPais($(this).val());
  });

  fieldFkSwPaisCorresp.on('change', function (e) {
    setVarJsCodPaisCorresp($(this).val());
  });
})(jQuery, window, UrbemSonata);
