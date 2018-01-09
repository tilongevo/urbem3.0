(function(){
    'use strict';

    var uniqId = $('meta[name="uniqid"]').attr('content'),
        fieldCodTipo = 'input[name="' + uniqId + '[codTipo]"]',
        fieldTipoValeTransporte = 'input[name="'+ uniqId + '[tipoValeTransporte]"]',
        fieldUtilizarGrupo = 'input[name="'+ uniqId + '[grupoConcessaoValeTransporte][utilizarGrupo]"]';

    var selectFormBasedValeTransporte = function(codTipoId){
            switch (codTipoId) {
                case 1:
                case 2:
                    formCodTipoMatricula();
                    break;
                case 3:
                    formCodTipoGrupo();
                    break;
            }
        },
        sonataFieldContainerHide = function(field) {
            var containerPrefix = "sonata-ba-field-container-" + uniqId;

            $("#" + containerPrefix + field).hide();
            $("#" + containerPrefix + field)
                .find('input, select')
                .each(function() {
                    $(this).removeAttr('required');
                });
        },
        sonataFieldContainerShow = function(field) {
            var containerPrefix = "sonata-ba-field-container-" + uniqId;

            $("#" + containerPrefix + field).show();

            if (field != "_grupoConcessaoValeTransporte_utilizarGrupo") {
                $("#" + containerPrefix + field)
                    .find('input, select')
                    .each(function() {
                        $(this).attr('required', true);
                    });
            }
        },
        formCodTipoGrupo = function() {
            sonataFieldContainerHide('_grupoConcessaoValeTransporte_utilizarGrupo');
            sonataFieldContainerShow('_grupoConcessaoValeTransporte_codGrupo_descricao');
            sonataFieldContainerHide('_contratoServidorConcessaoValeTransporte_codContrato');
        },
        formCodTipoMatricula = function() {
            sonataFieldContainerShow('_contratoServidorConcessaoValeTransporte_codContrato');
            sonataFieldContainerHide('_grupoConcessaoValeTransporte_codGrupo_descricao');
            sonataFieldContainerShow('_grupoConcessaoValeTransporte_utilizarGrupo');
        },
        formTipoValeTransporte = function(tipo) {
            if (tipo === 'mensal') {
                $('#' + uniqId + '_quantidade').prop('disabled', false);
                sonataFieldContainerHide('_concessaoValeTransporteCalendario_codCalendario');
            }
            else {
                $('#' + uniqId + '_quantidade').prop('disabled', true);
                sonataFieldContainerShow('_concessaoValeTransporteCalendario_codCalendario');
            }
        },
        utilizarGrupo = function() {
            sonataFieldContainerShow('_contratoServidorConcessaoValeTransporte_codGrupo');
            sonataFieldContainerHide('_contratoServidorConcessaoValeTransporte_vigencia');
            sonataFieldContainerHide('_contratoServidorConcessaoValeTransporte_codMes');
            sonataFieldContainerHide('_tipoValeTransporte');
            sonataFieldContainerHide('_codValeTransporte');
            sonataFieldContainerHide('_quantidade');
            sonataFieldContainerHide('_exercicio');
            sonataFieldContainerHide('_codMes');
        },
        naoUtilizarGrupo = function() {
            sonataFieldContainerHide('_contratoServidorConcessaoValeTransporte_codGrupo');
            sonataFieldContainerShow('_contratoServidorConcessaoValeTransporte_vigencia');
            sonataFieldContainerShow('_contratoServidorConcessaoValeTransporte_codMes');
            sonataFieldContainerShow('_tipoValeTransporte');
            sonataFieldContainerShow('_codValeTransporte');
            sonataFieldContainerShow('_quantidade');
            sonataFieldContainerShow('_exercicio');
            sonataFieldContainerShow('_codMes');

        };

    $(fieldUtilizarGrupo).on('ifChecked', function() {
        utilizarGrupo();
    });

    $(fieldUtilizarGrupo).on('ifUnchecked', function() {
        naoUtilizarGrupo();
    });

    $(fieldCodTipo).on('ifChecked', function() {
        var codTipoId = parseInt( $(this).val() );
        selectFormBasedValeTransporte(codTipoId);
    });

    $(fieldTipoValeTransporte).on('ifChecked', function() {
         var tipo = $(this).val();
         formTipoValeTransporte(tipo);
    });

    $(fieldTipoValeTransporte).each(function(index, elementId) {
        if ($(elementId).is(':checked')) {
            var tipo = $(elementId).val();
            formTipoValeTransporte(tipo);
        }
    });

    $(fieldCodTipo).each(function(index, elementId) {
        if ($(elementId).is(':checked')) {
            var codTipoId = parseInt( $(elementId).val() );
            selectFormBasedValeTransporte(codTipoId);
        }
    });

    if ($(fieldUtilizarGrupo).is(':checked')) {
        sonataFieldContainerShow('_contratoServidorConcessaoValeTransporte_codGrupo');
    } else {
        sonataFieldContainerHide('_contratoServidorConcessaoValeTransporte_codGrupo');
    }
}())
