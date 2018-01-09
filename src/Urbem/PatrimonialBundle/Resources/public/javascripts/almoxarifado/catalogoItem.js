(function(){
    'use strict';

    var codCatalogoField = UrbemSonata.giveMeBackMyField('codCatalogo');
    var codItemField = UrbemSonata.giveMeBackMyField('codItem');
    var edicao = UrbemSonata.giveMeBackMyField('edicao');
    jQuery('.atributoDinamicoWith').hide();

    var estoqueMinimo = UrbemSonata.giveMeBackMyField('estoqueMinimo');
    var estoqueMaximo = UrbemSonata.giveMeBackMyField('estoqueMaximo');
    var pontoPedido = UrbemSonata.giveMeBackMyField('pontoPedido');

    window.varJsCodCatalogo = 0;

    if (! UrbemSonata.checkModule('catalogo-item')) {
        return;
    }

    codCatalogoField.on('change', function () {
        var codCatalogo = $(this).val();
        if(!codCatalogo) {
            jQuery('.catalogoClassificacaoContainer').hide();
            return;
        }
        CatalogoClassificaoComponent.getNivelCategorias(codCatalogo);
    });
    codCatalogoField.trigger("change");

    jQuery(document).on('change', "select[id*='_nivelDinamico']:last", function () {
        var codClassificacao = $(this).val();
        if(codClassificacao == '' || codClassificacao == '0' || codClassificacao == 'Não há opções para o item escolhido.') {
            jQuery('.atributoDinamicoWith').hide();
            return ;
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

        if(codItemField.val() != 0 || codItemField.val() != '') {
            params.codTabela = codItemField.val();
        }

        AtributoDinamicoComponent.getAtributoDinamicoFields(params);
        jQuery('.atributoDinamicoWith').show();
        if(edicao.val() == '1') {
          UrbemSonata.giveMeBackMyField('fkAdministracaoUnidadeMedida').prop('readonly', 'readonly');
          UrbemSonata.giveMeBackMyField('fkAlmoxarifadoTipoItem').prop('readonly', 'readonly');
          codCatalogoField.prop('readonly', 'readonly');
          CatalogoClassificaoComponent.disabledAll();
        }
    });

    var returnVal = function (valor) {
        var result = parseFloat(valor.replace(/\./g, '').replace(/\,/g, '.') ).toFixed(2);
        return Number(result);
    };

    jQuery('.sonata-ba-form form').on('submit', function () {
        var error = false;
        var mensagem = '';

        jQuery('.sonata-ba-field-error-messages').remove();
        jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

        var valEstoqueMinimo = returnVal(estoqueMinimo.val());
        var valEstoqueMaximo = returnVal(estoqueMaximo.val());
        var valPontoPedido = returnVal(pontoPedido.val());

        if(valEstoqueMaximo < valEstoqueMinimo) {
            mensagem = 'O Estoque Máximo deve ser maior ou igual ao Estoque Mínimo.';

            estoqueMaximo.parent().addClass('sonata-ba-field-error');
            estoqueMaximo.parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i>' + mensagem + '</li> </ul> </div>');

            jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');

            return false;
        }

        if(valPontoPedido < valEstoqueMinimo) {
            mensagem = 'O Ponto de Pedido deve ser maior ou igual ao Estoque Mínimo.';

            pontoPedido.parent().addClass('sonata-ba-field-error');
            pontoPedido.parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i>' + mensagem + '</li> </ul> </div>');

            jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');

            return false;
        }

        if(valPontoPedido > valEstoqueMaximo) {
            mensagem = 'O Ponto de Pedido deve ser menor ou igual ao Estoque Máximo.';

            pontoPedido.parent().addClass('sonata-ba-field-error');
            pontoPedido.parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i>' + mensagem + '</li> </ul> </div>');

            jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');

            return false;
        }
    });

    if (!UrbemSonata.giveMeBackMyField('desmembravel').is(':checked')) {
        UrbemSonata.giveMeBackMyField('fkAdministracaoUnidadeMedida').closest('.form_row').hide();
    }
    
    UrbemSonata.giveMeBackMyField('desmembravel').on('ifChanged', function () {
        var me = $(this);

        if (me.is(':checked')) {
            UrbemSonata.giveMeBackMyField('fkAdministracaoUnidadeMedida').attr('required', 'required');
            UrbemSonata.giveMeBackMyField('fkAdministracaoUnidadeMedida').closest('.form_row').show();

            return;
        }

        UrbemSonata.giveMeBackMyField('fkAdministracaoUnidadeMedida').removeAttr('required');
        UrbemSonata.giveMeBackMyField('fkAdministracaoUnidadeMedida').closest('.form_row').hide();
    });
}());
