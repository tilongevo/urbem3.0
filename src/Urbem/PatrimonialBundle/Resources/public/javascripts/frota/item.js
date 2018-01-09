(function(){
    'use strict';

    if (! UrbemSonata.checkModule('item')) {
        return;
    }

    jQuery('.tipoCadastroItem').hide();
    jQuery('.tipoCadastroLote').hide();
    jQuery('.catalogoClassificacaoContainer').hide();
    UrbemSonata.sonataFieldContainerHide('_codItem');
    UrbemSonata.sonataFieldContainerHide('_codCatalogo');

    jQuery('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_avisoLote').removeClass('col s3');

    jQuery('#' + UrbemSonata.uniqId + '_tipoCadastro input').on('ifChecked', function () {
        if(jQuery(this).val() == 1) {
            UrbemSonata.sonataFieldContainerShow('_codItem');
            UrbemSonata.sonataFieldContainerHide('_codCatalogo');

            jQuery('.tipoCadastroItem').show();
            jQuery('.tipoCadastroLote').hide();
            jQuery('.catalogoClassificacaoContainer').hide();
        } else {
            UrbemSonata.sonataFieldContainerHide('_codItem');
            UrbemSonata.sonataFieldContainerShow('_codCatalogo');

            jQuery('.tipoCadastroItem').hide();
            jQuery('.tipoCadastroLote').show();
            jQuery('.catalogoClassificacaoContainer').hide();
        }
    });
    var tipoCadastro = $('#' + UrbemSonata.uniqId + '_tipoCadastro input[checked="checked"]').val();
    $('#' + UrbemSonata.uniqId + '_tipoCadastro input[value="'+tipoCadastro+'"]').trigger('ifChecked');
    if(jQuery('.tipoCadastro').hasClass('tipoCadastroHide')) {
        jQuery('.tipoCadastro').hide();
    }

    jQuery('#' + UrbemSonata.uniqId + '_codCatalogo').on('change', function () {
        var codCatalogo = jQuery("#" + UrbemSonata.uniqId + "_codCatalogo").val();
        if(!codCatalogo) {
            jQuery('.catalogoClassificacaoContainer').hide();
            return;
        }

        CatalogoClassificaoComponent.getNivelCategorias(codCatalogo);
    });

    jQuery('#' + UrbemSonata.uniqId + '_fkFrotaTipoItem').on('change', function () {
        if(jQuery(this).val() == 1) {
            UrbemSonata.sonataFieldContainerShow('_codCombustivel');
        } else {
            UrbemSonata.sonataFieldContainerHide('_codCombustivel');
        }
    });

    jQuery('#' + UrbemSonata.uniqId + '_fkFrotaTipoItem').trigger('change');
}());
