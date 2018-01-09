$(function () {
    "use strict";

    var codConstrucao = UrbemSonata.giveMeBackMyField('codConstrucao'),
        localizacao = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        lote = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLote_autocomplete_input"),
        imovel = $("#" + UrbemSonata.uniqId + "_fkImobiliarioImovel_autocomplete_input"),
        tipoEdificacao = UrbemSonata.giveMeBackMyField("fkImobiliarioTipoEdificacao"),
        tipoUnidade = UrbemSonata.giveMeBackMyField("tipoUnidade"),
        areaReal = UrbemSonata.giveMeBackMyField("areaReal"),
        areaTotalEdificada = UrbemSonata.giveMeBackMyField("areaTotalEdificada"),
        areaTotalEdificadaOriginal = 0.00;

    if (tipoEdificacao.val() == '') {
        $('#atributos-dinamicos').empty();
        $('#atributos-dinamicos').html('<span>Não existem atributos para o item selecionado.</span>');
    }

    tipoEdificacao.on("change", function() {
        carregaAtributos($(this).val(), codConstrucao.val())
    });

    function carregaAtributos(codTipo, codConstrucao) {
        if (codTipo == '') {
            $('#atributos-dinamicos').empty();
            $('#atributos-dinamicos').html('<span>Não existem atributos para o item selecionado.</span>');
            return false;
        }
        var params = {
            tabela: "CoreBundle:Imobiliario\\ConstrucaoEdificacao",
            fkTabela: "getFkImobiliarioAtributoTipoEdificacaoValores",
            tabelaPai: "CoreBundle:Imobiliario\\TipoEdificacao",
            codTabelaPai: {
                codTipo: codTipo
            },
            fkTabelaPaiCollection: "getFkImobiliarioAtributoTipoEdificacoes",
            fkTabelaPai: "getFkImobiliarioConstrucaoEdificacao"
        };

        if(codConstrucao != 0 || codConstrucao != '') {
            params.codTabela = { codTipo: codTipo, codConstrucao: codConstrucao };
        }

        AtributoDinamicoComponent.getAtributoDinamicoFields(params);
        $('.atributoDinamicoWith').show();
    }

    if (areaTotalEdificada == undefined) {
        return false;
    }
    areaTotalEdificada.attr('disabled', true);

    if (areaReal.val() != '') {
        areaTotalEdificadaOriginal = UrbemSonata.convertMoneyToFloat(areaTotalEdificada.val()) - UrbemSonata.convertMoneyToFloat(areaReal.val());
    }

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        if ($(this).val() != '') {
            lote.select2('enable');
            imovel.select2('enable');
        } else {
            lote.select2('val', '');
            lote.select2('disable');
            imovel.select2('val', '');
            imovel.select2('disable');
        }
        window.varJsCodLocalizacao = $(this).val();
    });

    window.varJsCodLote = lote.val();
    lote.on("change", function() {
        window.varJsCodLote = $(this).val();
    });

    if (localizacao.val() == '') {
        lote.select2('disable');
        imovel.select2('disable');
    }

    imovel.on("change", function () {
        cadastroImobiliario($(this).val());
        areaImovel($(this).val());
    });

    if (imovel.val() != '') {
        cadastroImobiliario(imovel.val());
        areaImovel(imovel.val());
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

    function areaImovel(inscricaoMunicipal) {
        $.ajax({
            url: "/tributario/cadastro-imobiliario/edificacao/imovel/area-imovel",
            method: "POST",
            data: {inscricaoMunicipal: inscricaoMunicipal},
            dataType: "json",
            success: function (data) {
                areaTotalEdificada.val(UrbemSonata.convertFloatToMoney(data.area_total));
                areaTotalEdificadaOriginal = parseFloat(data.area_total);
            }
        });
    }
    
    areaReal.on("change", function () {
        areaTotalEdificada.val(UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat($(this).val()) + areaTotalEdificadaOriginal));
    })
}());