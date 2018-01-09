$(function () {
    "use strict";

    var codCadastro = UrbemSonata.giveMeBackMyField('codCadastro'),
        codLote = UrbemSonata.giveMeBackMyField('codLote'),
        qtdLotes = UrbemSonata.giveMeBackMyField('quantidadeLotes'),
        areaOriginal = UrbemSonata.giveMeBackMyField('areaOriginal'),
        areaResultante = UrbemSonata.giveMeBackMyField('areaResultante'),
        unidadeMedida = UrbemSonata.giveMeBackMyField('fkAdministracaoUnidadeMedida');

    qtdLotes.mask('000');
    areaOriginal.attr('disabled', true);
    areaResultante.attr('disabled', true);
    unidadeMedida.attr('disabled', true);

    qtdLotes.on('change', function () {
        areaResultante.val(UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(areaOriginal.val()) / parseInt($(this).val())));
    });

    carregaAtributos(codCadastro.val());

    function carregaAtributos(codCadastro) {
        var data = {
            urbano: {
                entidade: "CoreBundle:Imobiliario\\LoteUrbano",
                getFkEntidadeAtributoValor: "getFkImobiliarioAtributoLoteUrbanoValores"
            },
            rural: {
                entidade: "CoreBundle:Imobiliario\\LoteRural",
                getFkEntidadeAtributoValor: "getFkImobiliarioAtributoLoteRuralValores"
            }
        };

        var params = {
            entidade: (codCadastro == 2) ? data.urbano.entidade : data.rural.entidade,
            fkEntidadeAtributoValor:(codCadastro == 2) ? data.urbano.getFkEntidadeAtributoValor : data.rural.getFkEntidadeAtributoValor,
            codModulo: "12",
            codCadastro: codCadastro
        };

        if(codLote.val() != 0 || codLote.val() != '') {
            params.codEntidade = {
                codLote: codLote.val()
            };
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }
}());