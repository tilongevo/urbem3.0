(function () {
  'use strict';
  var modalLoad = new UrbemModal();
  modalLoad.setTitle('Carregando...');

  var fieldCodEntidade, fieldCodModalidade, fieldExercicio, fieldCodLicitacao, loadTable;
  var formAction, regexpAutorizacaoEmpenhoLicitacao;
  formAction = $('form').prop("action");
  regexpAutorizacaoEmpenhoLicitacao = /(\/patrimonial\/licitacao\/autorizacao-empenho\/)/g;

  if (regexpAutorizacaoEmpenhoLicitacao.test(formAction)) {

    fieldCodEntidade = $('#' + UrbemSonata.uniqId + '_hCodEntidade'),
      fieldCodModalidade = $('#' + UrbemSonata.uniqId + '_hCodModalidade'),
      fieldExercicio = $('#' + UrbemSonata.uniqId + '_exercicio'),
      fieldCodLicitacao = $('#' + UrbemSonata.uniqId + '_hCodLicitacao'),
      loadTable = function (exercicio,codEntidade,codModalidade,codLicitacao) {
        modalLoad.setBody("Aguarde, processando dados.");
        modalLoad.open();
        $.get('/patrimonial/api/search/grupos-autorizacao-empenho-licitacao', {
          cod_entidade: fieldCodEntidade.val(),
          cod_modalidade: fieldCodModalidade.val(),
          exercicio: fieldExercicio.val(),
          cod_licitacao: fieldCodLicitacao.val(),
          mode: 'table'
        })
          .success(function (data) {
            $('.autorizacao-empenho-itens .box-body').html(data);
            modalLoad.close();
          });
      };

    if (fieldExercicio.val(),fieldCodEntidade.val(),fieldCodModalidade.val(),fieldCodLicitacao.val()) {
      loadTable(fieldExercicio.val(),fieldCodEntidade.val(),fieldCodModalidade.val(),fieldCodLicitacao.val());
    }
  }

  $('.btn-list').on('click', function () {
    modalLoad.setBody("Aguarde, processando dados.");
    modalLoad.open();
  });

  $('form .save').on('click', function () {
    modalLoad.setBody("Aguarde, processando dados.");
    modalLoad.open();
  });

}());
