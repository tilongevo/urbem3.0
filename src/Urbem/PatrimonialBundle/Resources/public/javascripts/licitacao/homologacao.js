(function () {
  'use strict';

    var fieldCodLicitacao = $('#' + UrbemSonata.uniqId + '_codHLicitacao'),
      fieldCodModalidade = $('#' + UrbemSonata.uniqId + '_codHModalidade'),
      fieldCodEntidade = $('#' + UrbemSonata.uniqId + '_codHEntidade'),
      fieldExercicio = $('#' + UrbemSonata.uniqId + '_exercicio'),
      loadTable = function (codLicitacao) {
        $.get('/patrimonial/api/search/itens/homologacao', {
          cod_licitacao: fieldCodLicitacao.val(),
          cod_modalidade: fieldCodModalidade.val(),
          cod_entidade: fieldCodEntidade.val(),
          exercicio: fieldExercicio.val(),
          mode: 'table'
        })
          .success(function (data) {
            $('.homologacao-items .box-body').html(data);
          });
      };

    if (fieldCodLicitacao.val()) {
      loadTable(fieldCodLicitacao.val());
    }

}());
