(function ($, urbem) {
    'use strict';

    var tipo = $('#filter_tipo_value'),
        cgmContrato = $('#filter_codContrato_value_autocomplete_input'),
        lotacao = $('#filter_lotacao_value');

    if (tipo.val() == undefined) {
        return false;
    }

    cgmContrato.select2('disable');
    lotacao.attr('disabled', true);

    tipo.on('change', function () {
        habilitaDesabilita($(this).val());
    });

    if (tipo.val() != '') {
        habilitaDesabilita(tipo.val()   );
    }

    function habilitaDesabilita(tipo) {
        if (tipo == 'cgm_contrato') {
            cgmContrato.select2('enable');
            lotacao.attr('disabled', true);
            lotacao.select2('val', '');
        } else if (tipo == 'lotacao') {
            cgmContrato.select2('disable');
            cgmContrato.select2('val', '');
            lotacao.attr('disabled', false);
        } else {
            cgmContrato.select2('disable');
            cgmContrato.select2('val', '');
            lotacao.attr('disabled', true);
            lotacao.select2('val', '');
        }
    }

    if (cgmContrato) {
        cgmContrato.on('change', function () {
            localStorage.setItem('contratoStorage', JSON.stringify($(this).select2('data')));
        });
        if (tipo.val() == 'cgm_contrato') {
            cgmContrato.select2('data', JSON.parse(localStorage.getItem('contratoStorage')));
        }
    }
    localStorage.removeItem('contratoStorage');

    if (lotacao) {
        lotacao.on('change', function () {
            localStorage.setItem('lotacaoStorage', JSON.stringify($(this).select2('data')));
        });

        if (tipo.val() == 'lotacao') {
            var selectedOptions = JSON.parse(localStorage.getItem('lotacaoStorage'));
            $.each(selectedOptions, function (key, item) {
                $("#filter_lotacao_value option[value='" + item.id + "']").prop("selected", true);
            });
        }
    }
    localStorage.removeItem('lotacaoStorage');

})(jQuery, UrbemSonata);