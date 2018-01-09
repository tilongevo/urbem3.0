$(function() {
    "use strict";

    if (! UrbemSonata.checkModule('pensao')) {
        return;
    }

    UrbemSonata.sonataFieldContainerHide("_funcao");

    var unique_id = $('meta[name="uniqid"]').attr("content");

    $('input[name="' + UrbemSonata.uniqId + '[descontoFixado]"]').on('ifChecked', function() {
        if( $(this).val() == 1 ){
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerShow("_pensaoValorCodPensaoValor_valor");
        }else{
            UrbemSonata.sonataFieldContainerShow("_funcao");
            UrbemSonata.sonataFieldContainerHide("_pensaoValorCodPensaoValor_valor");
        }
    });

    UrbemSonata.getMatricula = function () {
        $("#" + UrbemSonata.uniqId + "_inContrato").empty();
        $.ajax({
            url: "/recursos-humanos/pessoal/pensao/consultar-matricula",
            method: "POST",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_inContrato")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    $("#" + UrbemSonata.uniqId + "_inContrato")
                        .append("<option value=\"" + data[i] + "\">" + i + "</option>");
                }

                $("#" + UrbemSonata.uniqId + "_inContrato")
                    .val("");
            }
        });
    }

    UrbemSonata.getDependentes = function (numcgm) {
        $.ajax({
            url: "/recursos-humanos/pessoal/pensao/consultar-dependente",
            method: "POST",
            data: {
                numcgm: numcgm
            },
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_codDependente")
                    .empty();

                for (var i in data) {
                    $("#" + UrbemSonata.uniqId + "_codDependente")
                        .append("<option value=\"" + data[i] + "\">" + i + "</option>");
                }

                $("#" + UrbemSonata.uniqId + "_codDependente")
                    .val("");
            }
        });
    }

    UrbemSonata.getAgencia = function (codBanco) {
        $.ajax({
            url: "/recursos-humanos/pessoal/pensao/consultar-agencia",
            method: "POST",
            data: {
                codBanco: codBanco
            },
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_pensaoBancoCodPensaoBanco_codAgencia")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    $("#" + UrbemSonata.uniqId + "_pensaoBancoCodPensaoBanco_codAgencia")
                        .append("<option value=\"" + i + "\">" + data[i] + "</option>");
                }

                $("#" + UrbemSonata.uniqId + "_pensaoBancoCodPensaoBanco_codAgencia")
                    .val("");
            }
        });
    }

    UrbemSonata.sonataFieldContainerHide("_pensaoResponsavelLegal_codResponsavelLegal");
    $("#" + UrbemSonata.uniqId + "_codServidor").on("change", function () {
        UrbemSonata.getDependentes($(this).val());
    });

    $("#" + UrbemSonata.uniqId + "_pensaoBancoCodPensaoBanco_codBanco").on("change", function() {
        UrbemSonata.getAgencia($(this).val());
    });

    $('input[name="' + UrbemSonata.uniqId + '[rdoResponsavel]"]').on('ifChecked', function() {
        if ($(this).val() == "R") {
            UrbemSonata.sonataFieldContainerShow("_pensaoResponsavelLegal_codResponsavelLegal");
        } else {
            UrbemSonata.sonataFieldContainerHide("_pensaoResponsavelLegal_codResponsavelLegal");
        }
    });

    $("#" + unique_id + "_codServidor").on("change", function() {
        if ($(this).val() == '') {
            $("#" + unique_id + "_codMunicipio")
                .empty()
                .append("<option value=\"\">Selecione</option>");
            return false;
        }
        $.ajax({
            url: "/recursos-humanos/pessoal/pensao/listar-dependentes/" + $(this).val(),
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + unique_id + "_codDependente")
                    .empty()
                    .append("<option value=\"\">Selecione</option>")

                for (var i in data) {
                    $("#" + unique_id + "_codDependente")
                        .append("<option value=" + data[i] + ">" + i + "</option>");
                }

                $("#" + unique_id + "_codDependente")
                    .val("");
            }
        });
    });
});