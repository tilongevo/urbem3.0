/*global jQuery, UrbemSonata*/
(function ($, urbem) {
  'use strict';

  var attrDinamicoHelper = $.attrDinamicoAjaxReqHelper()
    , codGestaoField = urbem.giveMeBackMyField('codGestao')
    , codGestao = codGestaoField.val()
    , codModuloField = urbem.giveMeBackMyField('codModulo')
    , codModulo = codModuloField.val()
    , codCadastroField = urbem.giveMeBackMyField('codCadastro');

  codGestaoField.on('change', function () {
    codGestao = $(this).val();

    if (codGestao !== null && codGestao.trim() !== "") {
      attrDinamicoHelper.moduloRequest(codGestao, function (data) {
        attrDinamicoHelper.getModal().close();

        urbem.populateSelect(codModuloField, data, {value: 'value', label: 'label'});
        codModuloField.select2('enable');
      });
    }
  });

  codModuloField.on('change', function () {
    codModulo = $(this).val();

    if (codModulo !== null && codModulo.trim() !== "") {
      attrDinamicoHelper.cadastroRequest(codModulo, function (data) {
        attrDinamicoHelper.getModal().close();

        urbem.populateSelect(codCadastroField, data, {value: 'value', label: 'label'});
        codCadastroField.select2('enable');
      });
    }
  });

})(jQuery, UrbemSonata);
