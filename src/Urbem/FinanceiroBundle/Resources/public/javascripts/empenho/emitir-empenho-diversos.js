$(document).ready(function() {
    'use strict';

    var clear = function(select) {
        select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
    };

    var habilitarDesabilitar = function habilitarDesabilitarSelect(target, optionBoolean) {
        target.prop('disabled', optionBoolean);
    };

    function getDotacao( source, target ) {
        if ( source.val() == '' ) {
            return false;
        }
        clear($("#" + UrbemSonata.uniqId + "_codClassificacao"));
        clear(target);
        habilitarDesabilitar(target, true);
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
            success: function ( data ) {
                habilitarDesabilitar(target, false);
                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }
            }
        });
    }

    function getDtAutorizacao( source, target ) {
        if ( source.val() == '' ) {
            return false;
        }
        habilitarDesabilitar(target, true);

        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-dt-autorizacao",
            method: "POST",
            data: {
                codEntidade: source.val(),
                exercicio: $("#" + UrbemSonata.uniqId + "_exercicio").val()
            },
            dataType: "json",
            success: function (data) {
                habilitarDesabilitar(target, false);
                if (typeof(data) == "string") {
                    target.val(data);
                    target.attr('min', data);
                } else {
                    target.val('');
                }
            }
        });
    }

    function getDesdobramento( source, target ) {
        if ( source.val() == '' ) {
            return false;
        }
        habilitarDesabilitar(target, true);
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-desdobramento",
            method: "POST",
            data: {
                codDespesa: source.val(),
                exercicio: $("#" + UrbemSonata.uniqId + "_exercicio").val()
            },
            dataType: "json",
            success: function (data) {
                clear(target);
                habilitarDesabilitar(target, false);

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.val('').trigger("change");
            }
        });
    }

    function getSaldoDotacao( source, target ) {
        if ( source.val() == '' ) {
            return false;
        }
        clear(target);
        habilitarDesabilitar(target, true);
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
                habilitarDesabilitar(target, true);
                target.val(UrbemSonata.convertFloatToMoney(data));
            }
        });
    }

    function getOrgaoOrcamentario( source, target ) {
        if ( source.val() == '' ) {
            return false;
        }
        clear(target);
        habilitarDesabilitar(target, true);
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-orgao-orcamentario",
            method: "POST",
            data: {
                codEntidade: source.val(),
                exercicio: $("#" + UrbemSonata.uniqId + "_exercicio").val()
            },
            dataType: "json",
            success: function (data) {
                habilitarDesabilitar(target, false);
                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.val('').trigger("change");
            }
        });
    }

    function getOrgaoUnidade( source ) {
        if ( source.val() == '' ) {
            return false;
        }
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-orgao-unidade",
            method: "POST",
            data: {
                codDespesa: source.val(),
            },
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_numOrgao").val(data.numOrgao);
                $("#" + UrbemSonata.uniqId + "_numUnidade").val(data.numUnidade);
            }
        });
    }

    function getContrapartida( source, target )
    {
        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        var numcgm = $("input[name='" + UrbemSonata.uniqId + "[cgmBeneficiario]']").val();

        if (numcgm == '') {
            return false;
        }
        clear(target);
        habilitarDesabilitar(target, true);
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-contrapartida",
            method: "POST",
            data: {
                exercicio: exercicio,
                numcgm: numcgm
            },
            dataType: "json",
            success: function ( data ) {
                habilitarDesabilitar(target, false  );

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

    $("#" + UrbemSonata.uniqId + "_codEntidade").on("change", function () {
        getDtAutorizacao($(this), $("#" + UrbemSonata.uniqId + "_dtEmpenho"));
        getDotacao($(this), $("#" + UrbemSonata.uniqId + "_codDespesa"));
    });

    $("#filter_codEntidade_value").on("change", function () {
        getDotacao($(this), $("#filter_codDespesa_value"));
    });

    $("#" + UrbemSonata.uniqId + "_codDespesa").on("change", function () {
        getDesdobramento($(this), $("#" + UrbemSonata.uniqId + "_codClassificacao"));
        getSaldoDotacao($(this), $("#" + UrbemSonata.uniqId + "_saldoDotacao"));
        getOrgaoUnidade($(this));
    });

    $("#" + UrbemSonata.uniqId + "_codCategoria").on("change", function () {
        getContrapartida($(this), $("#" + UrbemSonata.uniqId + "_contaContrapartida"));
    });

    /* Item Pre Empenho*/
    function habilitarItem() {
        $("#" + UrbemSonata.uniqId + "_codItem").attr({
            disabled: false,
            required: true
        });
        $("#" + UrbemSonata.uniqId + "_nomItem").attr({
            disabled: true,
            required: false
        });
        $("#" + UrbemSonata.uniqId + "_codUnidade").attr({
            disabled: true,
            required: false
        });

        if ($("label[for='" + UrbemSonata.uniqId + "_nomItem']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_nomItem']").removeClass("required");
            $("label[for='" + UrbemSonata.uniqId + "_codItem']").addClass("required");
        }

        if ($("label[for='" + UrbemSonata.uniqId + "_codUnidade']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_codUnidade']").removeClass("required");
        }
    }

    function desabilitarItem() {
        $("#" + UrbemSonata.uniqId + "_codItem").attr({
            disabled: true,
            required: false
        });
        $("#" + UrbemSonata.uniqId + "_nomItem").attr({
            disabled: false,
            required: true
        });
        $("#" + UrbemSonata.uniqId + "_codUnidade").attr({
            disabled: false,
            required: true
        });

        if ($("label[for='" + UrbemSonata.uniqId + "_codItem']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_codItem']").removeClass("required");
            $("label[for='" + UrbemSonata.uniqId + "_nomItem']").addClass("required");
        }

        if (! $("label[for='" + UrbemSonata.uniqId + "_codUnidade']").hasClass("required")) {
            $("label[for='" + UrbemSonata.uniqId + "_codUnidade']").addClass("required");
        }
    }

    function getUnidadeMedida( source, target )
    {
        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        var numcgm = $("input[name='" + UrbemSonata.uniqId + "[cgmBeneficiario]']").val();

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
        var quantidade = $("#" + UrbemSonata.uniqId + "_quantidade").val(),
            vlUnitario = $("#" + UrbemSonata.uniqId + "_vlUnitario").val(),
            vlTotal;

        vlTotal = quantidade * UrbemSonata.convertMoneyToFloat(vlUnitario);
        $("#" + UrbemSonata.uniqId + "_vlTotal").val(UrbemSonata.convertFloatToMoney(vlTotal))
    }

    function calcularVlUnitario() {
        var quantidade = $("#" + UrbemSonata.uniqId + "_quantidade").val(),
            vlTotal = $("#" + UrbemSonata.uniqId + "_vlTotal").val(),
            vlUnitario;

        vlUnitario = vlTotal / quantidade;
        $("#" + UrbemSonata.uniqId + "_vlUnitario").val(UrbemSonata.convertFloatToMoney(vlUnitario))
    }

    $("#" + UrbemSonata.uniqId + "_codItem").attr({
        disabled: true,
        required: false
    });

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

    $("#" + UrbemSonata.uniqId + "_codItem").on("change", function () {
        getUnidadeMedida($(this), $("#" + UrbemSonata.uniqId + "_codUnidade"));
    });

    UrbemSonata.sonataFieldContainerHide("_contaContrapartida");

    UrbemSonata.giveMeBackMyField('dtEmpenho').on('change', function () {
        if (!$(this).attr('min')) {
            return false;
        }
        $('.sonata-ba-field-error-messages').remove();
        validarDtEmpenho($(this));
    });

    function validarDtEmpenho(fieldDtEmpenho) {
        var dtAtual = new Date(),
            res1 = fieldDtEmpenho.val().split("/"),
            date1 = new Date(res1[2], (parseInt(res1[1]) -1), res1[0],0,0,0),
            res2 = fieldDtEmpenho.attr('min').split("/"),
            date2 = new Date(res2[2], (parseInt(res2[1]) -1), res2[0],0,0,0),
            minDate = date2.getDate() + '/' + res2[1] + '/' + date2.getFullYear();
        if (date1 < date2) {
            UrbemSonata.setFieldErrorMessage('dtAutorizacao', 'Data de Empenho deve ser maior ou igual a \'' + minDate + '\'!', fieldDtEmpenho.parent().parent());
            fieldDtEmpenho.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
            fieldDtEmpenho.val(minDate);
            return false;
        } else if (date1 > dtAtual) {
            UrbemSonata.setFieldErrorMessage('dtAutorizacao', 'Data de Empenho deve ser menor ou igual a data atual!', fieldDtEmpenho.parent().parent());
            fieldDtEmpenho.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
            fieldDtEmpenho.val(minDate);
            return false;
        }
        return true;
    }

    $('form').on('submit', function () {
        if (!validarDtEmpenho(UrbemSonata.giveMeBackMyField('dtEmpenho'))) {
            return false;
        }
    });
}());
