(function () {
  'use strict';

  $("#" + UrbemSonata.uniqId + "_swClassificacao").on("change", function() {
    var codClassificacao = $(this).val();
    carregarAssunto(codClassificacao);
  });

  $("#" + UrbemSonata.uniqId + "_swAssunto").on("change", function() {
    var codClassificacao = $("#" + UrbemSonata.uniqId + "_swClassificacao").val();
    var codAssunto = $(this).val();
    carregarProcesso(codClassificacao, codAssunto);
  });

  $("#" + UrbemSonata.uniqId + "_swProcesso").on("change", function(data) {
      $("#" + UrbemSonata.uniqId + "_swProcessoEscolhido").append("<option value='" + $(this).val() + "'>" + $(this).val() + "</option>");
      $("#" + UrbemSonata.uniqId + "_swProcessoEscolhido option[value='" + $(this).val() + "']").prop("selected", true);
    $('select').select2();
  });

  var codClassificacao = $("#" + UrbemSonata.uniqId + "_swClassificacao").val();
  if (codClassificacao == '') {
  $("#" + UrbemSonata.uniqId + "_swAssunto")
      .empty()
      .append("<option value=\"\">Selecione</option>")
      .select2("val", "");
  } else {
    carregarUnidades(codClassificacao);
  }

  function carregarAssunto(codClassificacao) {
    $.ajax({
      url: "/patrimonial/licitacao/edital-impugnado/get-assunto-by-classificacao/?codClassificacao=" + codClassificacao,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_swAssunto")
          .empty()
          .append("<option value=\"\">Selecione</option>")
          .select2("val", "");

        $.each(data, function (index, value) {
          var codUnidade = $("#" + UrbemSonata.uniqId + "_numUnidadeUpdate").val();
          if (index == codUnidade) {
            $("#" + UrbemSonata.uniqId + "_swAssunto")
              .append("<option value=" + index + " selected>" + value + "</option>");
          } else {
            $("#" + UrbemSonata.uniqId + "_swAssunto")
              .append("<option value=" + index + ">" + value + "</option>");
          }
        });

        $("#" + UrbemSonata.uniqId + "_swAssunto").select2();
      }
    });
  }

  function carregarProcesso(codClassificacao,codAssunto) {
    $.ajax({
      url: "/patrimonial/licitacao/edital-impugnado/get-processo-by-classificacao-and-assunto/?codClassificacao=" + codClassificacao + "&codAssunto=" + codAssunto,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_swProcesso")
          .empty()
          .append("<option value=\"\">Selecione</option>")
          .select2("val", "");

        $.each(data, function (index, value) {
          var codUnidade = $("#" + UrbemSonata.uniqId + "_numUnidadeUpdate").val();
          if (index == codUnidade) {
            $("#" + UrbemSonata.uniqId + "_swProcesso")
              .append("<option value=" + index + " selected>" + value + "</option>");
          } else {
            $("#" + UrbemSonata.uniqId + "_swProcesso")
              .append("<option value=" + index + ">" + value + "</option>");
          }
        });

        $("#" + UrbemSonata.uniqId + "_swProcesso").select2();
      }
    });
  }

}());
