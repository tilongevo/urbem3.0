$(document).ready(function() {
    'use strict';
    var regexpClassificacaoEdit = /edit/,
        locationHref = document.location.href;

    var isEdit = regexpClassificacaoEdit.test(locationHref);

    // Proibe a edição do código de classificação
    if (isEdit) {
        $("#" + UrbemSonata.uniqId + "_codEstrutural").prop("readonly", true);
    }

    if ($("#" + UrbemSonata.uniqId + "_conta").val() == 'n' && isEdit) {
        $("#" + UrbemSonata.uniqId + "_entidade").prop("readonly", false);
    }

    if($("#" + UrbemSonata.uniqId + "_conta").val() == 'n'){
        UrbemSonata.sonataFieldContainerHide("_entidade");
        UrbemSonata.sonataFieldContainerHide("_banco");
        UrbemSonata.sonataFieldContainerHide("_agencia");
        UrbemSonata.sonataFieldContainerHide("_contaCorrente");
    }
    $("#" + UrbemSonata.uniqId + "_codEstrutural").mask($("#"+ UrbemSonata.uniqId + "_mascara").val());

    $("#" + UrbemSonata.uniqId + "_identificadorUso, #" + UrbemSonata.uniqId + "_grupoDestinacao, #" + UrbemSonata.uniqId + "_especificacaoDestinacao, #" + UrbemSonata.uniqId + "_detalhamentoDestinacao").on('change', function() {
        var identificadorUso = $("#" + UrbemSonata.uniqId + "_identificadorUso").val();
        identificadorUso = (identificadorUso) ? identificadorUso.split('-')[0] : "0";
        var grupoDestinacao = $("#" + UrbemSonata.uniqId + "_grupoDestinacao").val();
        grupoDestinacao = (grupoDestinacao) ? grupoDestinacao.split('-')[0] : "0";
        var especificacaoDestinacao = $("#" + UrbemSonata.uniqId + "_especificacaoDestinacao").val();
        especificacaoDestinacao = (especificacaoDestinacao) ? especificacaoDestinacao.split('-')[0] : "00";
        var detalhamentoDestinacao = $("#" + UrbemSonata.uniqId + "_detalhamentoDestinacao").val();
        detalhamentoDestinacao = (detalhamentoDestinacao) ? detalhamentoDestinacao.split('-')[0] : "000000";

        var string = identificadorUso + "." + grupoDestinacao + "." + especificacaoDestinacao + "." + detalhamentoDestinacao;
        $("#" + UrbemSonata.uniqId + "_destinacaoRedurso").val(string);
    });

    $("#" + UrbemSonata.uniqId + "_recursoContraPartida").on('change', function() {

        if($("#" + UrbemSonata.uniqId + "_recursoContraPartida").val()) {
            $("#" + UrbemSonata.uniqId + "_recurso").attr('required', true);
        } else {
            $("#" + UrbemSonata.uniqId + "_recurso").attr('required', false);
        }

    });

    if ($("#" + UrbemSonata.uniqId + "_conta").val() == 'n') {
        $("#" + UrbemSonata.uniqId + "_entidade").prop('disabled', false);
    }

    if ($("#" + UrbemSonata.uniqId + "_escrituracao").val() == 'sintetica') {
        UrbemSonata.sonataFieldContainerHide("_codSistema");
        UrbemSonata.sonataFieldContainerHide("_indicadorSuperavit");

        $("#" + UrbemSonata.uniqId + "_conta").val('n');
        $("#" + UrbemSonata.uniqId + "_conta").trigger( "change" );
        $("#" + UrbemSonata.uniqId + "_conta").prop('disabled', 'disabled');
        habilitaReadOnly("_recurso");
        habilitaReadOnly("_recursoContraPartida");
    }

    $("#" + UrbemSonata.uniqId + "_escrituracao").on('change', function() {
        UrbemSonata.sonataFieldContainerShow("_codSistema");
        UrbemSonata.sonataFieldContainerShow("_indicadorSuperavit");
        $("#" + UrbemSonata.uniqId + "_conta").prop('disabled', false);
        desabilitaReadOnly("_recurso");
        desabilitaReadOnly("_recursoContraPartida");

        if($(this).val() == 'sintetica'){
            UrbemSonata.sonataFieldContainerHide("_codSistema");
            UrbemSonata.sonataFieldContainerHide("_indicadorSuperavit");

            $("#" + UrbemSonata.uniqId + "_conta").val('n');
            $("#" + UrbemSonata.uniqId + "_conta").trigger( "change" );
            $("#" + UrbemSonata.uniqId + "_conta").prop('disabled', 'disabled');
            habilitaReadOnly("_recurso");
            habilitaReadOnly("_recursoContraPartida");
        }
    });

    $("#" + UrbemSonata.uniqId + "_conta").on('change', function() {
        UrbemSonata.sonataFieldContainerShow("_entidade");
        UrbemSonata.sonataFieldContainerShow("_banco");
        UrbemSonata.sonataFieldContainerShow("_agencia");
        UrbemSonata.sonataFieldContainerShow("_contaCorrente");

        if($(this).val() == 'n'){
            UrbemSonata.sonataFieldContainerHide("_entidade");
            UrbemSonata.sonataFieldContainerHide("_banco");
            UrbemSonata.sonataFieldContainerHide("_agencia");
            UrbemSonata.sonataFieldContainerHide("_contaCorrente");
        }
    });

    $("#" + UrbemSonata.uniqId + "_banco").on("change", function() {
        habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_agencia"), true, true);
        habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_contaCorrente"), true, true);
        var id = $(this).val();
        $.ajax({
            url: "/financeiro/contabilidade/planoconta/retorna-agencia/" + id,
            method: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function (data) {
                habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_agencia"), false, false);
                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_agencia")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });

    $("#" + UrbemSonata.uniqId + "_agencia").on("change", function() {
        habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_contaCorrente"), true, true);
        var id = $(this).val();
        $.ajax({
            url: "/financeiro/contabilidade/planoconta/retorna-conta/" + id,
            method: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function (data) {
                habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_contaCorrente"), false, false);

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_contaCorrente")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });

    $("#filter_banco_value").on("change", function() {
        var id = $(this).val();
        $.ajax({
            url: "/financeiro/contabilidade/planoconta/retorna-agencia/" + id,
            method: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function (data) {
                $("#filter_agencia_value")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $("#filter_contaCorrente_value")
                    .empty();

                $.each(data, function (index, value) {
                    $("#filter_agencia_value")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });

    $("#filter_agencia_value").on("change", function() {
        var id = $(this).val();
        $.ajax({
            url: "/financeiro/contabilidade/planoconta/retorna-conta/" + id,
            method: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function (data) {
                $("#filter_contaCorrente_value")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#filter_contaCorrente_value")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });

    function habilitarDesabilitar(target, optionBoolean, optionClear) {
        target.prop('disabled', optionBoolean);
        if (optionClear) {
            target
                .empty()
                .append("<option value=\"\">Selecione</option>")
                .val('').trigger("change");
        }
    }

    function habilitaReadOnly(fieldName) {
        $("#" + UrbemSonata.uniqId + fieldName).prop("readonly", "readonly");
        $("#" + UrbemSonata.uniqId + fieldName).attr("readonly", "readonly");
    }

    function desabilitaReadOnly(fieldName) {
        $("#" + UrbemSonata.uniqId + fieldName).removeAttr("readonly");
    }

    $('.form_row.col.s3.campo-sonata').eq(6).removeClass('.s3').addClass('s6');
}());
