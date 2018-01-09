$(function () {
    "use strict";

    var codCadastro = UrbemSonata.giveMeBackMyField('codCadastro'),
        codLote = UrbemSonata.giveMeBackMyField('codLote');

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

    $(".btn_meta").on("click", function() {
        var loteProcesso = $(this).attr('data-lote-processo');
        console.log(loteProcesso);
        if($(this).html() == 'add'){
            $('#lote_processo_' + loteProcesso).show();
            $(this).html('remove');
        }
        else{
            $('#lote_processo_' + loteProcesso).hide();
            $(this).html('add');
        }
    });
}());