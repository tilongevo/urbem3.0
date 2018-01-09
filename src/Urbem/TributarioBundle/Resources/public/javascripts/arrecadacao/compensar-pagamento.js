$(function () {
    "use strict";

    var parcelasSelecionadas = $("#parcelasSelecionadas");
    var totalCompensacao = $("#totalCompensacao");
    var saldoRestante = $("#saldoRestante");
    var valorACompensar = $("#valorCompensar");
    var aplicaAcrescimos = false;
    var removeChecked = false;
    var alertMessage = false;


    var filterContribuinte = $("input[name='filter[contribuinte][value]']");
    var filterImobiliaria = $("input[name='filter[inscricaoImobiliaria][value]']");
    var filterEconomica = $("input[name='filter[inscricaoEconomica][value]']");

    manageRequired();
    hidePagination();

    $(".pagasDuplicidades").on("ifChecked ifUnchecked", function() {
        sumAllChecked();
        subtractChecked();
    });

    $(".parcelasAVencer").on("ifChecked ifUnchecked", function() {
        sumAllChecked();
        subtractChecked();
    });

    $("#aplicaAcrescimos").on("ifChecked", function() {
        aplicaAcrescimos = true;
        sumAllChecked();
        subtractChecked();
    });

    $("#aplicaAcrescimos").on("ifUnchecked", function() {
        aplicaAcrescimos = false;
        sumAllChecked();
        subtractChecked();
    });

    // remove opção em branco e força a primeira opção selecionada
    $("select.js-origem-compensacao option:first").remove();

function hidePagination() {
    $("#pagination").parent().hide();
}

function sumAllChecked() {
    var contagem = 0;
    var valorParcela = 0;
    var parcela = 0;
    $(".pagasDuplicidades:checked").each(function() {

        contagem++;
        parcela = $(this).parent().parent().parent().find("td.js-valor-parcela").html();
        valorParcela += parseFloat(parcela);

    });

    setaValor(valorParcela);
}

function subtractChecked() {
    var contagem = 0;
    var valorParcela = 0;
    var parcela = 0;
    var novoSaldo = 0;
    var saldoAtual = parseFloat(saldoRestante.val());
    $(".parcelasAVencer:checked").each(function() {

        contagem++;

        if (aplicaAcrescimos) {
            parcela = $(this).parent().parent().parent().find("td.js-valor-pago").html();
        }

        if (!aplicaAcrescimos) {
            parcela = $(this).parent().parent().parent().find("td.js-valor-parcela").html();
        }

        valorParcela += parseFloat(parcela);
    });

    if (contagem > 1 && parseFloat(totalCompensacao.val() - valorParcela) <= 0.00) {
        $(".parcelasAVencer").iCheck("uncheck").iCheck("update");
        alertMessage = "Total a compensar insuficiente para carne.";
        alert(alertMessage);

        setTimeout(function() {
            $("input.parcelasAVencer").iCheck("uncheck").iCheck("update");
        }, 1000);

        return;
    }

    valorACompensar.val(valorParcela.toFixed(2));
    novoSaldo = saldoAtual - parseFloat(valorParcela);
    saldoRestante.val(novoSaldo.toFixed(2));
}

function setaValor(valor) {

    parcelasSelecionadas.val(valor.toFixed(2));
    totalCompensacao.val(valor.toFixed(2));
    saldoRestante.val(valor.toFixed(2));
}

function manageRequired() {

    var inputContribuinte = $("input#filter_contribuinte_value_autocomplete_input").prop("required", true);
    var selectEconomica = $("select#filter_inscricaoEconomica_value").prop("required", true);
    var inputImobiliaria = $("input#filter_inscricaoImobiliaria_value_autocomplete_input").prop("required", true);

    filterContribuinte.on("change", function() {
        if (filterContribuinte.val()) {
            inputImobiliaria.prop("required", false);
            selectEconomica.prop("required", false);
        }
    });

    filterImobiliaria.on("change", function() {
        if (filterImobiliaria.val()) {
            inputContribuinte.prop("required", false);
            selectEconomica.prop("required", false);
        }
    });

    filterEconomica.on("change", function() {
        if (filterEconomica.val()) {
            inputContribuinte.prop("required", false);
            inputImobiliaria.prop("required", false);
        }
    });
}

}());
