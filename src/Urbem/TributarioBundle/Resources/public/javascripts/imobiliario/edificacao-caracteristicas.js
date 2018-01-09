$(function () {
    "use strict";

    var codConstrucao = UrbemSonata.giveMeBackMyField('codConstrucao'),
        codTipo = UrbemSonata.giveMeBackMyField('codTipo');

    carregaAtributos();
    function carregaAtributos() {
        var params = {
            tabela: "CoreBundle:Imobiliario\\ConstrucaoEdificacao",
            fkTabela: "getFkImobiliarioAtributoTipoEdificacaoValores",
            tabelaPai: "CoreBundle:Imobiliario\\TipoEdificacao",
            codTabelaPai: {
                codTipo: codTipo.val()
            },
            fkTabelaPaiCollection: "getFkImobiliarioAtributoTipoEdificacoes",
            fkTabelaPai: "getFkImobiliarioAtributoTipoEdificacao"
        };

        if(codConstrucao != 0 || codConstrucao != '') {
            params.codTabela = { codTipo: codTipo.val(), codConstrucao: codConstrucao.val() };
        }

        AtributoDinamicoComponent.getAtributoDinamicoFields(params);
        $('.atributoDinamicoWith').show();
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