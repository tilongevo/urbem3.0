$(function () {
    "use strict";

    var condominio = UrbemSonata.giveMeBackMyField('codCondominio');

    carregaAtributos();
    function carregaAtributos() {
        var params = {
            entidade: "CoreBundle:Imobiliario\\Condominio",
            fkEntidadeAtributoValor: "getFkImobiliarioAtributoCondominioValores",
            codModulo: "12",
            codCadastro: "6"
        };

        if(condominio.val() != 0 || condominio.val() != '') {
            params.codEntidade = {
                codCondominio: condominio.val()
            };
        }

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