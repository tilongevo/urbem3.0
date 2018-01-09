$(function () {
    "use strict";

    var codConstrucao = UrbemSonata.giveMeBackMyField('codConstrucao'),
        codTipo = UrbemSonata.giveMeBackMyField('codTipo');

    carregaAtributos();
    function carregaAtributos() {
        var params = {
            entidade: "CoreBundle:Imobiliario\\ConstrucaoOutros",
            fkEntidadeAtributoValor: "getFkImobiliarioAtributoConstrucaoOutrosValores",
            codModulo: "12",
            codCadastro: "9",
            codEntidade: {
                codConstrucao: codConstrucao.val()
            }
        };

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }

    $(".btn_meta").on("click", function() {
        var loteProcesso = $(this).attr('data-lote-processo');
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