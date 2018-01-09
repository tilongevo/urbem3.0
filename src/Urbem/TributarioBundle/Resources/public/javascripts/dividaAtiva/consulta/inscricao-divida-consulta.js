$(function () {
    "use strict";

    var localizacaoDe = $('#filter_codLocalizacaoDe_value_autocomplete_input'),
        loteDe = $('#filter_codLoteDe_value_autocomplete_input'),
        imovelDe = $('#filter_inscricaoMunicipalDe_value_autocomplete_input'),
        localizacaoAte = $('#filter_codLocalizacaoAte_value_autocomplete_input'),
        loteAte = $('#filter_codLoteAte_value_autocomplete_input'),
        imovelAte = $('#filter_inscricaoMunicipalAte_value_autocomplete_input');

    window.varJsCodLocalizacaoDe = localizacaoDe.val();
    localizacaoDe.on("change", function() {
        if ($(this).val() != '') {
            loteDe.select2('enable');
        } else {
            loteDe.select2('val', '');
            loteDe.select2('disable');
            imovelDe.select2('val', '');
        }
        window.varJsCodLocalizacaoDe = $(this).val();
    });

    window.varJsCodLoteDe = loteDe.val();
    loteDe.on("change", function() {
        if ($(this).val() == '') {
            loteDe.select2('val', '');
            imovelDe.select2('val', '');
        }
        window.varJsCodLoteDe = $(this).val();
    });

    if (localizacaoDe.val() == '') {
        loteDe.select2('disable');
    }


    window.varJsCodLocalizacaoAte = localizacaoAte.val();
    localizacaoAte.on("change", function() {
        if ($(this).val() != '') {
            loteAte.select2('enable');
            imovelAte.select2('enable');
        } else {
            loteAte.select2('val', '');
            loteAte.select2('disable');
            imovelAte.select2('val', '');
        }
        window.varJsCodLocalizacaoAte = $(this).val();
    });

    window.varJsCodLoteAte = loteAte.val();
    loteAte.on("change", function() {
        if ($(this).val() == '') {
            loteAte.select2('val', '');
            imovelAte.select2('val', '');
        }
        window.varJsCodLoteAte = $(this).val();
    });

    if (localizacaoAte.val() == '') {
        loteAte.select2('disable');
    }

}());