$(function () {
    "use strict";

    var venalTerritorial = $('.js-venal-territorial').val();
    var venalPredial = $('.js-venal-predial').val();
    var venalTotal = $('.js-venal-total').val();
    var valorFinanciado = $('.js-valor-financiado');
    var inscricaoImobiliaria = $('.js-inscricao-imob');

    $('.js-venal-territorial').on('blur', function() {
        sumValues();
    });

    $('.js-venal-predial').on('blur', function() {
        sumValues();
    });

    function sumValues() {
        $('.js-venal-total').val('');
        var val1 = $('.js-venal-territorial').val();
        var val2 = $('.js-venal-predial').val();

        if (!val1) {
            val1 = '0,00';
        }

        if (!val2) {
            val2 = '0,00';
        }

        var sum = UrbemSonata.convertMoneyToFloat(val1) + UrbemSonata.convertMoneyToFloat(val2);

        $('.js-venal-total').val(UrbemSonata.convertFloatToMoney(sum));
    }

    var uri = location.pathname.split('/');
    var inscricaoM = (uri[uri.length - 2]).split('~');

    function carregaAtributos() {
        var params = {
            entidade: "CoreBundle:Arrecadacao\\ImovelVVenal",
            fkEntidadeAtributoValor: "getFkArrecadacaoAtributoImovelVVenalValores",
            codModulo: "25",
            codCadastro: "4",
        };

        if (uri[uri.length - 1] == 'edit') {
            params.codEntidade = {
                inscricaoMunicipal: inscricaoM[1],
                timestamp: $('.js-timestamp').val()
            };
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }

    carregaAtributos();

}());
