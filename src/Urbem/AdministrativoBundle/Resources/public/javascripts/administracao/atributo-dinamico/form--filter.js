(function ($, urbem) {
  'use strict';

  var attrDinamicoHelper = $.attrDinamicoAjaxReqHelper()
    , codGestaoField = $('#filter_codGestao_value')
    , codGestao = codGestaoField.val()
    , codModuloField = $('#filter_codModulo_value')
    , codModulo = codModuloField.val()
    , codCadastroField = $('#filter_codCadastro_value');

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
