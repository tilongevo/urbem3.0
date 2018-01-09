(function ($, urbem, global) {
    'use strict';

    var boFiltrarFolhaComplementar = urbem.giveMeBackMyField('boFiltrarFolhaComplementar'),
        inCodConfiguracao = urbem.giveMeBackMyField('inCodConfiguracao'),
        inCodComplementar = urbem.giveMeBackMyField('inCodComplementar'),
        inCodAtributo = urbem.giveMeBackMyField('inCodAtributo'),
        inCodAtributoId = inCodAtributo.prop('id'),
        inCodAtributoContainer = inCodAtributo.parent(),
        inAno = urbem.giveMeBackMyField('inAno'),
        inCodMes = urbem.giveMeBackMyField('inCodMes'),
        stTipoFiltro = urbem.giveMeBackMyField('stTipoFiltro'),
        inContrato = urbem.giveMeBackMyField('inContrato'),
        inContratoId = inContrato.prop('id'),
        inContratoContainer = inContrato.parent(),
        modal
    ;

    if (urbem.isFunction($.urbemModal)) {
        modal = $.urbemModal();
    }

    urbem.sonataFieldContainerShow("_inCodConfiguracao");
    urbem.sonataFieldContainerHide("_inCodComplementar");

    boFiltrarFolhaComplementar.on('ifChecked', function () {
        urbem.sonataFieldContainerShow("_inCodComplementar");
        urbem.sonataFieldContainerHide("_inCodConfiguracao");
    });

    boFiltrarFolhaComplementar.on('ifUnchecked', function () {
        urbem.sonataFieldContainerShow("_inCodConfiguracao");
        urbem.sonataFieldContainerHide("_inCodComplementar");
    });

    stTipoFiltro.on('change', function () {
        var atributoDinamico = $(':regex(id, (^s\\w+_\\d+_atributoDinamico))').first().attr("id").split("_");
        switch ($(this).val()) {
            case 'cgm_contrato':
                urbem.sonataFieldContainerHide("_inCodAtributo");
                urbem.sonataPanelHide("_" + atributoDinamico[1] + "_" + atributoDinamico[2]);
                urbem.sonataPanelShow("_inContrato");
                break;
            case 'atributo':
                urbem.sonataFieldContainerShow("_inCodAtributo");
                urbem.sonataPanelShow("_" + atributoDinamico[1] + "_" + atributoDinamico[2]);
                urbem.sonataPanelHide("_inContrato");
                break;
        }
    });

    stTipoFiltro.trigger('change');

    inCodMes.on('change', function () {
        modal.disableBackdrop()
            .setBody('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, Buscando Folha Complementar...</h4>')
            .open();
        $.post('/recursos-humanos/folha-pagamento/relatorios/folha-analitica-sintetica/folha-complementar-competencia', {
            inAno: inAno.val(),
            inCodMes: inCodMes.val()
        }).success(function (data) {
            urbem.populateSelect(inCodComplementar, data, {value: 'id', label: 'label'});
            modal.close();
        });
    });

    $(':regex(id, (^s\\w+_\\d+_atributoDinamico))').each(function (index, element) {
        var elementName = element.id.split("_");
        urbem.sonataFieldContainerHide("_" + elementName[1] + "_" + elementName[2]);
    });

    inCodAtributo.on('change', function() {
        var codAtributo = $(this).val();
        $(':regex(id, (^s\\w+_\\d+_atributoDinamico))').each(function(index, element) {
            var elementName = element.id.split("_");
            if (codAtributo == elementName[1]) {
                urbem.sonataFieldContainerShow("_" + elementName[1] + "_" + elementName[2]);
            } else {
                urbem.sonataFieldContainerHide("_" + elementName[1] + "_" + elementName[2]);
            }
        });
    });

    jQuery('button[name="btn_create_and_list"]').on('click', function (event) {
        var mensagem = '';
        jQuery('.sonata-ba-field-error-messages').remove();
        jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();


        if (stTipoFiltro.val() == 'cgm_contrato' && inContrato.val() == '') {
            event.preventDefault();
            mensagem = 'O Campo Matrícula não pode ficar vazio';

            $(".sonata-ba-field-error-messages").remove();
            UrbemSonata.setFieldErrorMessage(
                inContratoId,
                mensagem,
                inContratoContainer
            );

            jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
            return false;
        } else if (stTipoFiltro.val() == 'atributo') {
            if (inCodAtributo.val() == '') {
                event.preventDefault();
                mensagem = 'O Campo atributo dinâmico não pode ficar vazio';

                $(".sonata-ba-field-error-messages").remove();
                UrbemSonata.setFieldErrorMessage(
                    inCodAtributoId,
                    mensagem,
                    inCodAtributoContainer
                );

                jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
                return false;
            }else{
                $(':regex(id, (^s\\w+_\\d+_atributoDinamico))').each(function (index, element) {
                    var elementName = element.id.split("_");

                    var campo = urbem.giveMeBackMyField(elementName[1] + "_" + elementName[2]),
                                campoId = campo.prop('id'),
                                campoContainer = campo.parent();

                    if (campo.val() == '' && (elementName[1] == inCodAtributo.val())) {
                        event.preventDefault();
                        mensagem = 'O Campo atributo dinâmico não pode ficar vazio';

                        $(".sonata-ba-field-error-messages").remove();
                        UrbemSonata.setFieldErrorMessage(
                            campoId,
                            mensagem,
                            campoContainer
                        );

                        jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
                        return false;
                    }
                });
            }
        }
    });
})
(jQuery, UrbemSonata, window);
