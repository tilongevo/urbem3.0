$(function () {
    "use strict";

    var inscricaoMunicipal = UrbemSonata.giveMeBackMyField('inscricaoMunicipal');

    carregaAtributos();

    function carregaAtributos() {
        var params = {
            entidade: "CoreBundle:Imobiliario\\Imovel",
            fkEntidadeAtributoValor:"getFkImobiliarioAtributoImovelValores",
            codModulo: "12",
            codCadastro: "4"
        };

        if(inscricaoMunicipal.val() != 0 || inscricaoMunicipal.val() != '') {
            params.codEntidade = {
                inscricaoMunicipal: inscricaoMunicipal.val()
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