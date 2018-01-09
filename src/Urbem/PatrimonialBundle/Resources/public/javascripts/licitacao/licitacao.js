(function () {
  'use strict';
  $("#" + UrbemSonata.uniqId + "_itens").prop("disabled", true);
  if (!UrbemSonata.checkModule('licitacao')) {
    return;
  }

  var fieldLicitacao = $("#" + UrbemSonata.uniqId + "_codLicitacao");
  var fieldEntidade = $("#" + UrbemSonata.uniqId + "_fkOrcamentoEntidade");
  var fieldModalidade = $("#" + UrbemSonata.uniqId + "_fkComprasModalidade");
  var fieldExercicio = $("#" + UrbemSonata.uniqId + "_codHExercicio");

  $("#" + UrbemSonata.uniqId + "_numOrgao").on("change", function () {
    var codOrgao = $(this).val();
    carregarUnidades(codOrgao);
  });

  var codOrgao = $("#" + UrbemSonata.uniqId + "_numOrgao").val();
  if (codOrgao == '') {
    $("#" + UrbemSonata.uniqId + "_numUnidade")
      .empty()
      .append("<option value=\"\">Selecione</option>")
      .select2("val", "");
  } else {
    carregarUnidades(codOrgao);
  }

  if (fieldModalidade.val()) {
    fieldModalidade.prop('readonly', true);
    fieldEntidade.prop('readonly', true);
  }

  function carregarUnidades(codOrgao) {
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
        $.each(data, function (index, value) {
          var codUnidade = $("#" + UrbemSonata.uniqId + "_numUnidadeUpdate").val();
          if (index == codUnidade) {
            $("#" + UrbemSonata.uniqId + "_numUnidade")
              .append("<option value=" + index + " selected>" + value + "</option>");
          } else {
            $("#" + UrbemSonata.uniqId + "_numUnidade")
              .append("<option value=" + index + ">" + value + "</option>");
          }
        });

        $("#" + UrbemSonata.uniqId + "_numUnidade").select2();
      }
    });
  }

  function findUnidadeByOrgao(orgao) {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando unidades</h4>');
    $("#" + UrbemSonata.uniqId + "_unidade").empty();
    $("#" + UrbemSonata.uniqId + "_unidade").prop("disabled", 'disabled');

    var codOrgao = orgao.val();
    $.ajax({
      url: "/financeiro/plano-plurianual/acao/consultar-unidades",
      method: "POST",
      data: {codOrgao: codOrgao},
      dataType: "json",
      success: function (data) {
        var getCodUnidade = UrbemSonata.giveMeBackMyField('codUnidade');
        $("#" + UrbemSonata.uniqId + "_unidade")
          .empty()
          .append("<option value=\"\">Selecione</option>");

        $.each(data, function (index, value) {
          var selectedMod = '';
          if (index == parseInt(getCodUnidade.val())) {
            selectedMod = ' selected="selected"';
          }
          $("#" + UrbemSonata.uniqId + "_unidade")
            .append("<option " + selectedMod + " value=" + index + ">" + value + "</option>");
        });
        $("#" + UrbemSonata.uniqId + "_unidade").prop("disabled", false);


        fechaModal();
      }
    });
  }

  $('form').submit(function () {
    if (fieldLicitacao.val() != 'undefined') {
      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, verificando código da licitação</h4>');
      $.ajax({
        url: "/patrimonial/licitacao/licitacao/verifica-licitacao-exsitente?exercicio=" + fieldExercicio.val() + '&entidade=' + fieldEntidade.val() + '&modalidade=' + fieldModalidade.val() + '&codLicitacao=' + fieldLicitacao.val(),
        method: "GET",
        dataType: "json",
        success: function (data) {
          if (data.status) {
            fechaModal();
            return true;
          } else {
            fieldLicitacao.parent().parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Código da Licitação já cadastrado.</li> </ul> </div>');
            fechaModal();
            return false;
          }

        }
      });
    }

  });

  $(function () {
    var fieldComprasModalidade = $("#" + UrbemSonata.uniqId + "_fkComprasModalidade");
    var arrayModalities = ["8", "9", "10"];
    if ($.inArray(fieldComprasModalidade.val(), arrayModalities) < 0) {
      UrbemSonata.sonataFieldContainerHide('_codTipoChamadaPublica');
    }

    $(fieldComprasModalidade).on("change", function () {
      if ($.inArray(fieldComprasModalidade.val(), arrayModalities) < 0) {
        UrbemSonata.sonataFieldContainerHide('_codTipoChamadaPublica');
      } else {
        UrbemSonata.sonataFieldContainerShow('_codTipoChamadaPublica');
      }
    });

    $("#" + UrbemSonata.uniqId + "_unidade").prop("disabled", 'disabled');
    $("#" + UrbemSonata.uniqId + "_orgaoOrg").on("change", function () {
      findUnidadeByOrgao($(this));
    });

    UrbemSonata.sonataFieldContainerHide('_fkLicitacaoTipoChamadaPublica');

    if (($("#" + UrbemSonata.uniqId + "_fkComprasMapa").val() != "") && ($("#" + UrbemSonata.uniqId + "_fkComprasMapa").val() !== undefined)) {
      var codMapa = $("#" + UrbemSonata.uniqId + "_fkComprasMapa").val();
      var exercicio = $("#" + UrbemSonata.uniqId + "_codHExercicio").val();

      loadTable(codMapa, exercicio);
    }

    if (($("#" + UrbemSonata.uniqId + "_comissao").val() != "") && ($("#" + UrbemSonata.uniqId + "_comissao").val() !== undefined)) {
      var codComissao = $("#" + UrbemSonata.uniqId + "_comissao").val();

      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando dados da comissão</h4>');
      $.ajax({
        url: "/patrimonial/licitacao/licitacao/get-membros-comissao/?codComissao=" + codComissao,
        method: "GET",
        dataType: "json",
        success: function (data) {
          $("#" + UrbemSonata.uniqId + "_fkComprasModalidade")
            .empty()
            .append("<option value=\"\">Selecione</option>");

          if (typeof data === 'object') {
            $.each(data, function (index, value) {
              $("#" + UrbemSonata.uniqId + "_comissaoMembros")
                .append("<option value='" + index + "'>" + value + "</option>");
              $("#" + UrbemSonata.uniqId + "_comissaoMembros option[value='" + index + "']").prop("selected", true);
            });

          }
          fechaModal();
        }
      });
    }

  });

  var loadTable = function (codMapa, exercicio) {
    if (codMapa == '' || codMapa == '0') {
      return;
    }


    $.get('/patrimonial/licitacao/licitacao/get-itens-licitacao', {
      codMapa: codMapa,
      exercicio: exercicio,
      mode: 'table'
    })
      .success(function (mapaItem) {
        $('.comprasdireta-items .box-body').html(mapaItem);

        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando dados do Mapa</h4>');
        $.ajax({
          url: "/patrimonial/licitacao/licitacao/carrega-informacoes-mapa/?codMapa=" + codMapa + "&exercicio=" + exercicio,
          method: "GET",
          dataType: "json",
          success: function (infoMapa) {
            var registroPreco;
            infoMapa.registroPrecos == 'Sim' ? registroPreco = 'Sim' : registroPreco = 'Não';

            $('#' + UrbemSonata.uniqId + "_registroPrecos").val(registroPreco);
            $('#' + UrbemSonata.uniqId + "_tipoCotacao").val(infoMapa.tipoLicitacao);
            $('#' + UrbemSonata.uniqId + "_vlCotado").val(infoMapa.vlTotal);
            var getModalidade = $('#' + UrbemSonata.uniqId + "_getModalidade").val();

            $.ajax({
              url: "/patrimonial/licitacao/licitacao/carrega-modalidade/?registroPrecos=" + infoMapa.registroPrecos,
              method: "GET",
              dataType: "json",
              success: function (modalidade) {
                $("#" + UrbemSonata.uniqId + "_fkComprasModalidade")
                  .empty()
                  .append("<option value=\"\">Selecione</option>");

                $.each(modalidade.itens, function (index, value) {
                  var selectedMod = '';
                  if (value.id == getModalidade) {
                    selectedMod = ' selected="selected"';
                  }
                  $("#" + UrbemSonata.uniqId + "_fkComprasModalidade")
                    .append("<option " + selectedMod + " value='" + value.id + "'>" + value.label + "</option>");
                });
                if (getModalidade == '') {
                  $("#" + UrbemSonata.uniqId + "_fkComprasModalidade").prop('disabled', false);
                }

                fechaModal();

                var orgaoOrg = UrbemSonata.giveMeBackMyField('orgaoOrg');
                if (orgaoOrg.val() != '') {
                  findUnidadeByOrgao(orgaoOrg);
                }
              }
            });
          }
        });
      });
  };

  $("#" + UrbemSonata.uniqId + "_fkComprasMapa").on("change", function () {
    var codMapa = $(this).val();
    var exercicio = $("#" + UrbemSonata.uniqId + "_codHExercicio").val();
    loadTable(codMapa, exercicio);
  });

  $("#" + UrbemSonata.uniqId + "_comissao").on("change", function () {
    var codComissao = $(this).val();
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando dados da comissão</h4>');
    $.ajax({
      url: "/patrimonial/licitacao/licitacao/get-membros-comissao/?codComissao=" + codComissao,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_comissaoMembros")
          .empty()
          .append("<option value=\"\">Selecione</option>");

        if (typeof data === 'object') {
          $.each(data, function (index, value) {
            $("#" + UrbemSonata.uniqId + "_comissaoMembros")
              .append("<option value='" + index + "'>" + value + "</option>");
            $("#" + UrbemSonata.uniqId + "_comissaoMembros option[value='" + index + "']").prop("selected", true);
          });
        }

        $("#" + UrbemSonata.uniqId + "_comissaoMembros").select2();

        fechaModal();
      }
    });
  });

  UrbemSonata.sonataFieldContainerHide('_fkLicitacaoTipoChamadaPublica');
  $("#" + UrbemSonata.uniqId + "_fkComprasModalidade").on("change", function () {
    var modalidade = $(this).val();
    if ('8' == modalidade || '9' == modalidade) {
      UrbemSonata.sonataFieldContainerShow('_fkLicitacaoTipoChamadaPublica');
    } else {
      UrbemSonata.sonataFieldContainerHide('_fkLicitacaoTipoChamadaPublica');
    }
  });

}());
