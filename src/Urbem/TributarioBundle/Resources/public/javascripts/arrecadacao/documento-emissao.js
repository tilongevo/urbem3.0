$(function () {
    "use strict";

    var localizacao = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        lote = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLote_autocomplete_input"),
        imovel = $("#" + UrbemSonata.uniqId + "_fkImobiliarioImovel_autocomplete_input"),
        fkArrecadacaoDocumentoCgns = $("#s2id_" + UrbemSonata.uniqId + "_fkArrecadacaoDocumentoCgns_autocomplete_input"),
        fkImobiliarioLocalizacao = $("#s2id_" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        inscricaoEconomica = $("#s2id_" + UrbemSonata.uniqId + "_inscricaoEconomica_autocomplete_input"),
        documento = UrbemSonata.giveMeBackMyField('fkArrecadacaoDocumento'),
        tipo = UrbemSonata.giveMeBackMyField('tipo');

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        if ($(this).val() != '') {
            lote.select2('enable');
            imovel.select2('enable');
        } else {
            lote.select2('val', '');
            lote.select2('disable');
            imovel.select2('val', '');
        }
        window.varJsCodLocalizacao = $(this).val();
    });

    window.varJsCodLote = lote.val();
    lote.on("change", function() {
        window.varJsCodLote = $(this).val();
    });

    if (localizacao.val() == '') {
        lote.select2('disable');
    }

    imovel.on("change", function () {
        cadastroImobiliario($(this).val());
    });

    if (imovel.val() != '') {
        cadastroImobiliario(imovel.val());
    }

    if (documento.val() == ''){
        fkArrecadacaoDocumentoCgns.select2('disable');
        fkImobiliarioLocalizacao.select2('disable');
        inscricaoEconomica.select2('disable');
        imovel.select2('disable');
    }

    documento.on('change', function () {
        if(documento.val() != ''){
            fkArrecadacaoDocumentoCgns.select2('enable');
            fkImobiliarioLocalizacao.select2('enable');
            inscricaoEconomica.select2('enable');
            imovel.select2('enable');
        }else{
            fkArrecadacaoDocumentoCgns.select2('disable');
            fkImobiliarioLocalizacao.select2('disable');
            inscricaoEconomica.select2('disable');
            fkArrecadacaoDocumentoCgns.select2('val','');
            fkImobiliarioLocalizacao.select2('val','');
            inscricaoEconomica.select2('val','');
            imovel.select2('disable');
            localizacao.change();
        }
    });

    tipo.on("change", function() {

        var botao ='button[name="btn_create_and_list"]';

        if (tipo.val() == 'reemissao') {
            $(botao).html("<i class='material-icons left'>list</i> Listar ");
        } else {
            $(botao).html("<i class='material-icons left'>save</i> Salvar");
        }

    });

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