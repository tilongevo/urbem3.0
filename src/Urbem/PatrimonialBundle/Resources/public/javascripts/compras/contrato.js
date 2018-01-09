(function () {
  'use strict';

  var modalLoad = new UrbemModal();
  modalLoad.setTitle('Carregando...');

  var choiceContrato = UrbemSonata.giveMeBackMyField("contrato"),
    modalidade = UrbemSonata.giveMeBackMyField("modalidade"),
    exercicioLicitacao = UrbemSonata.giveMeBackMyField("exercicioLicitacaoCompra"),
    entidade = UrbemSonata.giveMeBackMyField("fkOrcamentoEntidade");

  function carregarUnidades(codOrgao) {

    modalLoad.setBody("Aguarde, pesquisando Unidades");
    modalLoad.open();

    $.ajax({
      url: "/financeiro/plano-plurianual/acao/consultar-unidades",
      method: "POST",
      data: {codOrgao: codOrgao},
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_numUnidade")
          .empty()
          .append("<option value=\"\">Selecione</option>")
          .select2("val", "");

          var codUnidade = $("#" + UrbemSonata.uniqId + "_numUnidadeUpdate").val();var codUnidade = $("#" + UrbemSonata.uniqId + "_numUnidadeUpdate").val();
        $.each(data, function (index, value) {
          if (index == codUnidade) {
            $("#" + UrbemSonata.uniqId + "_numUnidade")
              .append("<option value=" + index + " selected>" + value + "</option>");
          } else {
            $("#" + UrbemSonata.uniqId + "_numUnidade")
              .append("<option value=" + index + ">" + value + "</option>");
          }
        });
        modalLoad.close();
        $('select').select2();
      }
    });
  }

  function carregarLicitacaoCompraDireta(choiceContrato,modalidade,exercicioLicitacao,entidade) {
    modalLoad.setBody("Aguarde, pesquisando Licitações / Compras Diretas");
    modalLoad.open();
    //console.log(choiceContrato,modalidade,exercicioLicitacao,entidade, url);
    $.ajax({
      url: "/patrimonial/api/search/carrega-licitacao-compra-direta?contrato=" + choiceContrato.val() + "&modalidade=" + modalidade.val() + "&exercicio=" + exercicioLicitacao.val() + "&entidade=" + entidade.val(),
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_licitacaoCompra")
          .empty()
          .append("<option value=\"\" id=''>Selecione</option>")
          .select2("val", "");
        $.each(data, function (index, value) {
          console.log(value);
            $("#" + UrbemSonata.uniqId + "_licitacaoCompra")
              .append("<option value=" + value.id + ">" + value.label + "</option>");
        });
        modalLoad.close();
        $('select').select2();
      }
    });

  }

  $("#" + UrbemSonata.uniqId + "_numOrgao").on("change", function () {
    var codOrgao = $(this).val();
    if(codOrgao != "") {
        carregarUnidades(codOrgao);
    }else{
        $("#" + UrbemSonata.uniqId + "_numUnidade")
        .empty()
        .append("<option value=\"\">Selecione</option>")
        .select2("val", "");
    }
  });

  $("#" + UrbemSonata.uniqId + "_modalidade").on("change", function () {
      var comprasTipoObjeto = $(this).val();
      var contrato = $("#" + UrbemSonata.uniqId + "_contrato").val();
      //choiceContrato = contrato;
      console.log('alo', contrato, choiceContrato);
      if(comprasTipoObjeto != "") {
          carregarLicitacaoCompraDireta(choiceContrato,modalidade,exercicioLicitacao,entidade);
      }else{
          $("#" + UrbemSonata.uniqId + "_licitacaoCompra")
              .empty()
              .append("<option value=\"\">Selecione</option>")
              .select2("val", "");
      }
  });
}());