(function () {
    'use strict';

    var codCatalogoField = UrbemSonata.giveMeBackMyField('codCatalogo');
    var codItemField = UrbemSonata.giveMeBackMyField('codItem');
    var edicao = UrbemSonata.giveMeBackMyField('edicao');
    jQuery('.atributoDinamicoWith').hide();
    window.varJsCodCatalogo = 0;

    codCatalogoField.on('change', function () {
        var codCatalogo = $(this).val();
        if (!codCatalogo) {
            jQuery('.catalogoClassificacaoContainer').hide();
            return;
        }

        CatalogoClassificaoComponent.getNivelCategorias(codCatalogo);
    });
    codCatalogoField.trigger("change");

    jQuery(document).on('change', "select[id*='_nivelDinamico']:last", function () {
        var codClassificacao = $(this).val();
        if (codClassificacao == '' || codClassificacao == '0' || codClassificacao == 'Não há opções para o item escolhido.') {
            jQuery('.atributoDinamicoWith').hide();
            return;
        }
        var params = {
            tabela: "CoreBundle:Almoxarifado\\CatalogoItem",
            fkTabela: "getFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores",
            tabelaPai: "CoreBundle:Almoxarifado\\CatalogoClassificacao",
            codTabelaPai: {
                codCatalogo: codCatalogoField.val(),
                codEstrutural: codClassificacao
            },
            fkTabelaPaiCollection: "getFkAlmoxarifadoAtributoCatalogoClassificacoes",
            fkTabelaPai: "getFkAlmoxarifadoAtributoCatalogoClassificacao"
        };

        if (codItemField.val() != 0 || codItemField.val() != '') {
            params.codTabela = codItemField.val();
        }

        if (edicao.val() == '1') {
            codCatalogoField.prop('readonly', 'readonly');
            CatalogoClassificaoComponent.disabledAll();
        }
    });
}());
