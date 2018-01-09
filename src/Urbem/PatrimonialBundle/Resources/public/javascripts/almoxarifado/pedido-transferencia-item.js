(function () {
  'use strict';

  if (!UrbemSonata.checkModule('pedido-transferencia-item')) {
    return;
  }

  $('.init-readonly').prop('readonly', true);

  UrbemSonata.giveMeBackMyField("codItem").on("change", function () {
    var codItem = $(this).val();
    var codAlmoxarifado = $("#" + UrbemSonata.uniqId + "_codHAlmoxarifado").val();

    if (codItem == '') {
      $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca")
        .empty()
        .prop('readonly', true);

      $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto")
        .empty()
        .prop('readonly', true);

      $("#" + UrbemSonata.uniqId + "_codPedidoTransferenciaItemDestino_fkAlmoxarifadoCentroCustoDestino")
        .empty()
        .prop('readonly', true);
      return;
    }

    $.ajax({
      url: "/patrimonial/almoxarifado/requisicao-item/get-marca-catalogo/?codItem=" + codItem + "&codAlmoxarifado=" + codAlmoxarifado,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca").prop('readonly', false);
        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca")
          .empty();
        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca").prop("required", true);
        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca")
          .append("<option value='0'>Selecione...</option>");
        $.each(data, function (index, value) {
          $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca")
            .append("<option value='" + index + "'>" + value + "</option>");
        });
        $('select').select2();
      }
    });

    var cgmHSolicitante = $("#" + UrbemSonata.uniqId + "_cgmHSolicitante").val();

    $.ajax({
      url: "/patrimonial/almoxarifado/pedido-transferencia-item/get-centro-custo-destino/?codItem=" + codItem + "&codAlmoxarifado=" + codAlmoxarifado+ "&numCgm=" + cgmHSolicitante,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_codCentroDestino").prop('readonly', false);
        $("#" + UrbemSonata.uniqId + "_codCentroDestino")
          .empty();

        $("#" + UrbemSonata.uniqId + "_codCentroDestino")
          .append("<option value='0'>Selecione...</option>");
        $.each(data['cod_centro'], function (index, value) {
          $("#" + UrbemSonata.uniqId + "_codCentroDestino")
            .append("<option value='" + index + "'>" + value + "</option>");
        });
        $('select').select2();
      }
    });
  });

  $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca").on("change", function () {
    var codMarca = $(this).val();
    var codItem = UrbemSonata.giveMeBackMyField("codItem").val();
    var codAlmoxarifado = $("#" + UrbemSonata.uniqId + "_codHAlmoxarifado").val();
    var cgmHSolicitante = $("#" + UrbemSonata.uniqId + "_cgmHSolicitante").val();

    if (codMarca == 0) {
      $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto").prop('readonly', true);
      $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto")
        .empty();
      return;
    }

    $.ajax({
      url: "/patrimonial/almoxarifado/requisicao-item/get-centro-custo-catalogo/?codMarca="+ codMarca +"&codItem=" + codItem + "&codAlmoxarifado=" + codAlmoxarifado+ "&numCgm=" + cgmHSolicitante,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto").prop('readonly', false);
        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto")
          .empty();

        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto")
          .append("<option value='0'>Selecione...</option>");
        $.each(data['cod_centro'], function (index, value) {
          $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto")
            .append("<option value='" + index + "'>" + value + "</option>");
        });
        $('select').select2();
      }
    });
  });

  $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto").on("change", function () {
    var codCentro = $(this).val();
    var codMarca =$("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoMarca").val();
    var codItem = UrbemSonata.giveMeBackMyField("codItem").val();
    var codAlmoxarifado = $("#" + UrbemSonata.uniqId + "_codHAlmoxarifado").val();

    if(codItem.indexOf(" - ") != -1) {
      codItem = codItem.split(" - ");
      codItem = codItem[0];
    }

    if (codMarca == 0) {
      $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto")
        .empty();
      return;
    }

    $.ajax({
      url: "/patrimonial/almoxarifado/requisicao-item/get-saldo-estoque/?codMarca="+ codMarca +"&codItem=" + codItem + "&codAlmoxarifado=" + codAlmoxarifado+ "&codCentro=" + codCentro,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_saldo").prop("readonly",true);
        $("#" + UrbemSonata.uniqId + "_saldo").val((((parseFloat(data['valor_saldo'] - $("#" + UrbemSonata.uniqId + "_quantidade").val().replace(',','.'))).toFixed(4)).toString().replace(/\,/g,'') ).replace(/\./g,','));
      }
    });
  });
  $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCentroCusto").trigger('change');

}());
