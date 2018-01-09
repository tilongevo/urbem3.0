(function ($, urbem) {
  'use strict';

  var modal = $.urbemModal();

  var choiceContrato = UrbemSonata.giveMeBackMyField("contrato"),
    fieldModalidade = UrbemSonata.giveMeBackMyField("modalidade"),
    fieldExercicioLicitacao = UrbemSonata.giveMeBackMyField("exercicio"),
    fieldLicitacao = UrbemSonata.giveMeBackMyField("licitacaoCompra"),
    fieldEntidade = UrbemSonata.giveMeBackMyField("codEntidade");

  function carregarLicitacaoEdital() {
    $.ajax({
      url: "/patrimonial/api/search/carrega-licitacao-edital",
      data: {
        modalidade: fieldModalidade.val(),
        exercicio: fieldExercicioLicitacao.val(),
        entidade: fieldEntidade.val()
      },
      method: "GET",
      dataType: "json",
      beforeSend: function (xhr) {
        modal
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando as Licitações dessa Modalidade.')
          .open();
      },
      success: function (data) {
        urbem.populateSelect(fieldLicitacao, data, {
          value: 'id',
          label: 'label'
        });

        modal.close();
      }
    });
  }

  function carregarDadosLicitacao() {
    $.ajax({
      url: "/patrimonial/api/search/carrega-dados-licitacao",
      data: {
        modalidade: fieldModalidade.val(),
        exercicio: fieldExercicioLicitacao.val(),
        entidade: fieldEntidade.val(),
        licitacao: fieldLicitacao.val()
      },
      method: "GET",
      dataType: "json",
      beforeSend: function (xhr) {
        modal
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando dados da Licitação.')
          .open();
      },
      success: function (data) {
        $.each(data, function (index, value) {
          $("#" + UrbemSonata.uniqId + "_swProcesso").val(data.processo);
          $("#" + UrbemSonata.uniqId + "_valor").val(data.valor);
        });

        modal.close();
      }
    });
  }

  $(document).ready(function() {
    fieldModalidade.select2(fieldEntidade.val() == '' ? 'disable' : 'enable');
    fieldLicitacao.select2(fieldModalidade.val() == '' ? 'disable' : 'enable');

    if (fieldLicitacao.val() != '' && fieldLicitacao.val() != null) {
      carregarDadosLicitacao();
    }
  });

  fieldEntidade.on('change', function (event) {
    fieldModalidade.select2($(this).val() == '' ? 'disable' : 'enable');
  });

  fieldModalidade.on('change', function (event) {
    if ($(this).val() != '') {
      carregarLicitacaoEdital();
      fieldLicitacao.select2('enable');
    } else {
      fieldLicitacao.select2('disable');
    }
  });

  fieldLicitacao.on('change', function (event) {
    if ($(this).val() != '' && $(this).val() != null) {
      carregarDadosLicitacao();
    }
  });

})(jQuery, UrbemSonata);
