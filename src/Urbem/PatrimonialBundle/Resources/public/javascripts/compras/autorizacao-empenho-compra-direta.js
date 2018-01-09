(function () {
  'use strict';

  var UrbemSearch = UrbemSonata.UrbemSearch,
    formAction = $('form').prop("action"),
    regexpAutorizacaoCompraDireta = /(\/patrimonial\/compras\/autorizar-empenho-compra-direta\/)/g;

  if (regexpAutorizacaoCompraDireta.test(formAction)) {

    var fieldCodEntidade = $('#' + UrbemSonata.uniqId + '_hcodEntidade'),
        fieldCodModalidade = $('#' + UrbemSonata.uniqId + '_hcodModalidade'),
        fieldExercicio = $('#' + UrbemSonata.uniqId + '_hexercicio'),
        fieldCodCompraDireta = $('#' + UrbemSonata.uniqId + '_hcodCompraDireta'),
        loadTable = function (exercicio,codEntidade,codModalidade,codCompraDireta) {
          $.get('/patrimonial/api/search/autorizacao-empenho-compra-direta', {
            cod_entidade: fieldCodEntidade.val(),
            cod_modalidade: fieldCodModalidade.val(),
            exercicio: fieldExercicio.val(),
            cod_compra_direta: fieldCodCompraDireta.val(),
            mode: 'table'
          })
              .success(function (data) {
                $('.comprasdireta-items .box-body').html(data);
              });
        };

    if (fieldExercicio.val(),fieldCodEntidade.val(),fieldCodModalidade.val(),fieldCodCompraDireta.val()) {
      loadTable(fieldExercicio.val(),fieldCodEntidade.val(),fieldCodModalidade.val(),fieldCodCompraDireta.val());
    }
  }

}());
