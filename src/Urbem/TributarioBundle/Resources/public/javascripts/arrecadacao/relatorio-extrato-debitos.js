$(function () {
    "use strict";

    var localizacao = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        lote = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLote_autocomplete_input"),
        imovel = $("#" + UrbemSonata.uniqId + "_fkImobiliarioImovel_autocomplete_input"),
        fkImobiliarioLocalizacao = $("#s2id_" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        inscricaoEconomica = $("#s2id_" + UrbemSonata.uniqId + "_inscricaoEconomica_autocomplete_input");

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        if ($(this).val() != '') {
        } else {
            lote.select2('val', '');
            imovel.select2('val', '');
        }
        window.varJsCodLocalizacao = $(this).val();
    });

    window.varJsCodLote = lote.val();
    lote.on("change", function() {
        window.varJsCodLote = $(this).val();
    });

    imovel.on("change", function () {
        cadastroImobiliario($(this).val());
    });

    if (imovel.val() != '') {
        cadastroImobiliario(imovel.val());
    }

    function cadastroImobiliario(inscricaoMunicipal) {
        $.ajax({
            url: "/tributario/cadastro-imobiliario/edificacao/imovel/unidade-autonoma",
            method: "POST",
            data: {inscricaoMunicipal: inscricaoMunicipal},
            dataType: "json",
            success: function (data) {
                if (data) {
                    tipoUnidade.select2('val', '1');
                } else {
                    tipoUnidade.select2('val', '0');
                }
            }
        });
    }
}());