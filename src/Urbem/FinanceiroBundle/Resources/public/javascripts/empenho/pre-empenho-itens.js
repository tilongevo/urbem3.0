$(document).ready(function() {
    'use strict';

    var tipoItem = $("#" + UrbemSonata.uniqId + "_tipoItem_0"),
        itemAlmoxarifado = $("#" + UrbemSonata.uniqId + "_fkAlmoxarifadoCatalogoItem_autocomplete_input"),
        descricao = $("#" + UrbemSonata.uniqId + "_nomItem"),
        unidadeMedida = $("#" + UrbemSonata.uniqId + "_fkAdministracaoUnidadeMedida"),
        quantidade = $("#" + UrbemSonata.uniqId + "_quantidade"),
        vlUnitario = $("#" + UrbemSonata.uniqId + "_vlUnitario"),
        vlTotal = $("#" + UrbemSonata.uniqId + "_vlTotal"),
        dotacao = $("#" + UrbemSonata.uniqId + "_dotacao"),
        saldoDotacao = $("#" + UrbemSonata.uniqId + "_saldoDotacao");

    if (vlTotal.val() === undefined) {
        return false;
    }

    tipoItem.on('ifChecked', function () {
        desabilitarItem();
    });

    tipoItem.on('ifUnchecked', function () {
        habilitarItem();
    });

    if (tipoItem.is(':checked')) {
        desabilitarItem();
    } else {
        habilitarItem();
    }

    function habilitarItem() {
        itemAlmoxarifado.attr({
            disabled: false,
            required: true
        });

        UrbemSonata.sonataFieldContainerHide("_codItem");
        UrbemSonata.sonataFieldContainerShow("_fkAlmoxarifadoCatalogoItem");

        descricao.attr({
            disabled: true,
            required: false
        });

        unidadeMedida.attr({
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

        descricao.attr({
            disabled: false,
            required: true
        });

        unidadeMedida.attr({
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

    function getUnidadeMedida(codItem)
    {
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-unidade-medida-item",
            method: "POST",
            data: { codItem: codItem },
            dataType: "json",
            success: function (data) {
                unidadeMedida.select2('val', data.codigoComposto);
            }
        });
    }

    function calcularVlTotal() {
        var vlTotal = (UrbemSonata.convertMoneyToFloat(quantidade.val()) * UrbemSonata.convertMoneyToFloat(vlUnitario.val()));
        $("#" + UrbemSonata.uniqId + "_vlTotal").val(UrbemSonata.convertFloatToMoney(vlTotal))
    }

    function calcularVlUnitario() {
        if (quantidade.val() && vlTotal.val()) {
            console.log('teste');
            vlUnitario.val(UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(vlTotal.val()) / UrbemSonata.convertMoneyToFloat(quantidade.val())))
        }
    }

    calcularVlUnitario();
    $("#" + UrbemSonata.uniqId + "_quantidade, #" + UrbemSonata.uniqId + "_vlUnitario").on("blur", function() {
        vlTotal.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
        calcularVlTotal();
    });

    itemAlmoxarifado.on("change", function () {
        getUnidadeMedida($(this).val());
    });

    $('form').on('submit', function () {
        if ((dotacao.val()) && ( UrbemSonata.convertMoneyToFloat(vlTotal.val()) > saldoDotacao.val())) {
            UrbemSonata.setFieldErrorMessage('vlTotal', 'Valor Total ultrapassa o Saldo da Dotação! (R$' + UrbemSonata.convertFloatToMoney(saldoDotacao.val()) + ')', vlTotal.parent().parent());
            return false;
        }
    });
}());