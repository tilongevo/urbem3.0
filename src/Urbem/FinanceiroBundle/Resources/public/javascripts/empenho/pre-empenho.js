String.prototype.replaceAll = function(str1, str2, ignore)
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
};
$(document).ready(function() {
    'use strict';

    function getDotacao(source, target) {
        if (source.val() == '') {
            return false;
        }

        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        if (typeof(exercicio) == "undefined") {
            var exercicio = $("#filter_exercicio_value").val();
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-dotacao",
            method: "POST",
            data: {
                codEntidade: source.val(),
                exercicio: exercicio
            },
            dataType: "json",
            success: function (data) {
                target
                    .prop('disabled', false)
                    .empty()
                    .append("<option value=\"\">Selecione</option>")

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.val('').trigger("change");
            }
        });
    }

    function getDtAutorizacao(source, target) {
        if (source.val() == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-dt-autorizacao",
            method: "POST",
            data: {
                codEntidade: source.val(),
                exercicio: $("#" + UrbemSonata.uniqId + "_exercicio").val()
            },
            dataType: "json",
            success: function (data) {
                target.prop('disabled', false);
                if (typeof(data) == "string") {
                    target.val(data);
                } else {
                    target.val('');
                }
            }
        });
    }

    function getDesdobramento(source, target) {
        if (source.val() == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-desdobramento",
            method: "POST",
            data: {
                codDespesa: source.val(),
                exercicio: $("#" + UrbemSonata.uniqId + "_exercicio").val()
            },
            dataType: "json",
            success: function (data) {
                target
                    .prop('disabled', false)
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.val('').trigger("change");
            }
        });
    }

    function getSaldoDotacao(source, target) {
        if (source.val() == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-saldo-dotacao",
            method: "POST",
            data: {
                stExercicio: $("#" + UrbemSonata.uniqId + "_exercicio").val(),
                inCodDespesa: source.val(),
                stDataEmpenho: $("#" + UrbemSonata.uniqId + "_dtAutorizacao").val(),
                inEntidade: $("#" + UrbemSonata.uniqId + "_codEntidade").val(),
            },
            dataType: "json",
            success: function (data) {
                if (typeof(data) == "string") {
                    target.val(data);
                } else {
                    target.val('');
                }
            }
        });
    }

    function getOrgaoOrcamentario(source, target) {
        if (source.val() == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-orgao-orcamentario",
            method: "POST",
            data: {
                codEntidade: source.val(),
                exercicio: $("#" + UrbemSonata.uniqId + "_exercicio").val()
            },
            dataType: "json",
            success: function (data) {
                target
                    .prop('disabled', false)
                    .empty()
                    .append("<option value=\"\">Selecione</option>")

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.val('').trigger("change");
            }
        });
    }

    function getUnidadeOrcamentaria(source, target) {
        if (source.val() == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-unidade-orcamentaria",
            method: "POST",
            data: {
                numOrgao: source.val(),
                codEntidade: $("#" + UrbemSonata.uniqId + "_codEntidade").val()
            },
            dataType: "json",
            success: function (data) {
                target
                    .prop('disabled', false)
                    .empty()
                    .append("<option value=\"\">Selecione</option>")

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.val('').trigger("change");
            }
        });
    }

    function getContrapartida(source, target)
    {
        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        var numcgm = $("input[name='" + UrbemSonata.uniqId + "[fkSwCgm]']").val();

        if (numcgm == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-contrapartida",
            method: "POST",
            data: {
                exercicio: exercicio,
                numcgm: numcgm
            },
            dataType: "json",
            success: function (data) {
                target
                    .empty()
                    .append("<option value=\"\">Selecione</option>")

                if (data.length > 0) {
                    sonataFieldContainerShow("_contaContrapartida", true);

                    for (var i in data) {
                        target.append("<option value=" + i + ">" + data[i] + "</option>");
                    }

                    target.val('').trigger("change");
                }

            }
        });
    }

    var config = {
        targetDtAutorizacao : $("#" + UrbemSonata.uniqId + "_dtAutorizacao"),
        targetDotacao : $("#" + UrbemSonata.uniqId + "_codDespesa"),
        targetOrgaoOrcamentario : $("#" + UrbemSonata.uniqId + "_numOrgao"),
        targetCodClassificacao : $("#" + UrbemSonata.uniqId + "_codClassificacao"),
        targetNumUnidade : $("#" + UrbemSonata.uniqId + "_numUnidade"),
        targetSaldoDotacao : $("#" + UrbemSonata.uniqId + "_saldoDotacao"),
        targetCodEntidade : $("#" + UrbemSonata.uniqId + "_codEntidade"),
        targetContaContraPartida : $("#" + UrbemSonata.uniqId + "_contaContrapartida"),
        targetCodCategoria : $("#" + UrbemSonata.uniqId + "_codCategoria")
    };

    config.targetCodEntidade.on("change", function () {
        config.targetCodClassificacao
            .prop('disabled', true)
            .empty()
            .append("<option value=\"\">Selecione</option>");
        config.targetCodClassificacao.val('').trigger("change");

        config.targetNumUnidade
            .prop('disabled', true)
            .empty()
            .append("<option value=\"\">Selecione</option>");
        config.targetNumUnidade.val('').trigger("change");

        config.targetDtAutorizacao.prop('disabled', true);
        config.targetDotacao.prop('disabled', true);
        config.targetOrgaoOrcamentario.prop('disabled', true);

        getDtAutorizacao($(this), config.targetDtAutorizacao);
        getDotacao($(this), config.targetDotacao);
        getOrgaoOrcamentario($(this), config.targetOrgaoOrcamentario);
    });

    $("#filter_codEntidade_value").on("change", function () {
        getDotacao($(this), $("#filter_codDespesa_value"));
    });

    config.targetDotacao.on("change", function () {
        config.targetCodClassificacao.prop('disabled', true);
        config.targetSaldoDotacao.prop('disabled', true);

        getDesdobramento($(this), config.targetCodClassificacao);
        getSaldoDotacao($(this), config.targetSaldoDotacao);
    });

    config.targetOrgaoOrcamentario.on("change", function () {
        config.targetNumUnidade.prop('disabled', true);
        getUnidadeOrcamentaria($(this), config.targetNumUnidade);
    });

    config.targetCodCategoria.on("change", function () {
        getContrapartida($(this), config.targetContaContraPartida);
    });

    /* Item Pre Empenho*/
    function habilitarItem() {
        $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCatalogoItem").attr({
            disabled: false,
            required: true
        });

        UrbemSonata.sonataFieldContainerHide("_codItem");
        UrbemSonata.sonataFieldContainerShow("_fkAlmoxarifadoCatalogoItem");

        $("#" + UrbemSonata.uniqId + "_nomItem").attr({
            disabled: true,
            required: false
        });
        $("#" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida").attr({
            disabled: true,
            required: false
        });

        if ($("label[for='" + UrbemSonata.uniqId + "_nomItem']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_nomItem']").removeClass("required");
            $("label[for='" + UrbemSonata.uniqId + "_fkAlmoxarifadoCatalogoItem']").addClass("required");
        }

        if ($("label[for='" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida']").removeClass("required");
        }
    }

    function desabilitarItem() {

        UrbemSonata.sonataFieldContainerShow("_codItem");
        UrbemSonata.sonataFieldContainerHide("_fkAlmoxarifadoCatalogoItem");

        $("#" + UrbemSonata.uniqId + "_nomItem").attr({
            disabled: false,
            required: true
        });
        $("#" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida").attr({
            disabled: false,
            required: true
        });

        if ($("label[for='" + UrbemSonata.uniqId + "_fkAlmoxarifadoCatalogoItem']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_fkAlmoxarifadoCatalogoItem']").removeClass("required");
            $("label[for='" + UrbemSonata.uniqId + "_nomItem']").addClass("required");
        }

        if (! $("label[for='" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida']").addClass("required");
        }
    }

    function getUnidadeMedida(source, target)
    {
        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        var numcgm = $("input[name='" + UrbemSonata.uniqId + "[fkSwCgm]']").val();

        if (numcgm == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-unidade-medida",
            method: "POST",
            data: {
                codItem: source.val(),
            },
            dataType: "json",
            success: function (data) {
                target.val(data).trigger("change");
            }
        });
    }

    function calcularVlTotal() {
        var quantidade = $("#" + UrbemSonata.uniqId + "_quantidade").val().replaceAll(".", "").replaceAll(",","."),
            vlUnitario = $("#" + UrbemSonata.uniqId + "_vlUnitario").val().replaceAll(".", "").replaceAll(",","."),
            vlTotal;

        vlTotal = (quantidade * vlUnitario);
        $("#" + UrbemSonata.uniqId + "_vlTotal").val(UrbemSonata.convertFloatToMoney(vlTotal))
    }

    function calcularVlUnitario() {
        var quantidade = $("#" + UrbemSonata.uniqId + "_quantidade").val().replaceAll(".", "").replaceAll(",","."),
            vlTotal = $("#" + UrbemSonata.uniqId + "_vlTotal").val().replaceAll(".", "").replaceAll(",","."),
            vlUnitario;

        if (quantidade || vlTotal) {
            vlUnitario = (vlTotal / quantidade);
            $("#" + UrbemSonata.uniqId + "_vlUnitario").val(UrbemSonata.convertFloatToMoney(vlUnitario))
        }
    }

    if (typeof($("#" + UrbemSonata.uniqId + "_tipoItem_0").iCheck('update')[0]) != "undefined") {
        if ($("#" + UrbemSonata.uniqId + "_tipoItem_0").iCheck('update')[0].checked) {
            habilitarItem();
        } else {
            desabilitarItem();
        }
    } else {
        desabilitarItem();
    }

    $("#" + UrbemSonata.uniqId + "_tipoItem_0").on('ifChecked', function () {
        habilitarItem();
    });

    $("#" + UrbemSonata.uniqId + "_tipoItem_0").on('ifUnchecked', function () {
        desabilitarItem();
    });

    calcularVlUnitario();
    $("#" + UrbemSonata.uniqId + "_quantidade, #" + UrbemSonata.uniqId + "_vlUnitario").on("blur", function() {
        calcularVlTotal();
    });

    $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCatalogoItem").on("change", function () {
        getUnidadeMedida($(this), $("#" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida"));
    });

    UrbemSonata.sonataFieldContainerHide("_contaContrapartida");

    jQuery("form").on('submit', function () {
        $("#" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida").attr({
            disabled: false,
            required: true
        });
        $("#" + UrbemSonata.uniqId + "_nomItem").attr({
            disabled: false,
            required: true
        });
    });
}());