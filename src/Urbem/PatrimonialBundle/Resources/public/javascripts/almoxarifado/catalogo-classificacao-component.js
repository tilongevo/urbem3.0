'use strict';
var CatalogoClassificaoComponent = CatalogoClassificaoComponent || {};

CatalogoClassificaoComponent = {
    estrutural: function (estrutural) {
        if(typeof(jQuery("#" + UrbemSonata.uniqId + "_codEstrutural").val()) != 'undefined') {
            return jQuery("#" + UrbemSonata.uniqId + "_codEstrutural").val().split(".");
        }
        return (typeof(estrutural) != 'undefined' ? estrutural : []);
    },
    nivel: function (nivel) {
        if(CatalogoClassificaoComponent.estrutural().length) {
            return CatalogoClassificaoComponent.estrutural().length;
        }
        return (typeof(nivel) !== 'undefined' ? nivel : '0');
    },
    buildEstrutural: function (nivel) {
        var estrutural = [];
        for(var $i = 0; $i < nivel; $i++) {
            estrutural.push(CatalogoClassificaoComponent.estrutural()[$i]);
        }
        return estrutural.join('.');
    },
    getNivelCategorias: function (codCatalogo, codNivel, codNivelT) {
        if (codNivel == 0 || codNivelT == 1) {
            jQuery('.catalogoClassificacaoContainer').hide();
            UrbemSonata.sonataFieldContainerHide('catalogoClassificacaoPlaceholder');
            return;
        }

        codNivel = (typeof(codNivel) !== 'undefined' ? codNivel : 0);
        codNivelT = (typeof(codNivelT) !== 'undefined' ? codNivelT : 0);

        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, processando os niveis</h4>');
        jQuery.ajax({
            url: "/patrimonial/almoxarifado/catalogo-classificacao/get-nivel-categorias/?codNivel=" + codNivelT + "&codCatalogo=" + codCatalogo,
            method: "GET",
            dataType: "json",
            success: function (data) {
                jQuery('.catalogoClassificacaoContainer').show();
                jQuery("#catalogo-classificao").empty();
                jQuery.each(data, function (index, value) {
                    if (value) {
                        jQuery("#catalogo-classificao").append(value);
                    } else {
                        jQuery("#catalogo-classificao").append('<span>Não existem Níveis a inserir.</span>');
                    }
                });
                fechaModal();
                // jQuery("#catalogo-classificao").select2();
            }
        });
    },
    disabledAll: function () {
        jQuery('select.classificacao_niveis').each(function () {
            jQuery(this).prop('readonly', 'readonly');
            jQuery('select').select2();
        });
    }
};

(function () {
    jQuery('.catalogoClassificacaoContainer').hide();
    jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_catalogoClassificacaoPlaceholder").hide();
    jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_catalogoClassificacaoPlaceholder").after('<div id="catalogo-classificao" class="col s12"></div>');

    jQuery('.sonata-ba-form form').on('submit', function () {
        var error = false;
        jQuery('select.classificacao_niveis').each(function () {
            if(jQuery(this).val() == 0 || jQuery(this).val() == "" || jQuery(this).val() == "Não há opções para o item escolhido.") {
                error = true;
                if(!jQuery(this).parent().hasClass('sonata-ba-field-error')) {
                    jQuery(this).parent().addClass('sonata-ba-field-error');
                    jQuery(this).parent().append('<div class="help-block sonata-ba-field-error-messages"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Campos obrigatório vazio.</li> </ul> </div>');
                }
            }
        });

        if(error) {
            if(!jQuery('.sonata-ba-form').parent().find('.alert').length) {
                jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Há campos obrigatórios vazios, por favor, verifique. </div>');
            }
            return false;
        }
    })
}());
