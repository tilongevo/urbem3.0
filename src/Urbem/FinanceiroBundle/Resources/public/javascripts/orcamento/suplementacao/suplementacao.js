$(document).ready(function() {
    'use strict';

    $("#" + UrbemSonata.uniqId + "_codTipo").on('change', function() {
        UrbemSonata.sonataFieldContainerShow("_codSuplementacaoReducao");

        var suplementacoesRedutoras = ['1', '3', '8', '12', '13', '14', '15'];

        if ($.inArray($(this).val(), suplementacoesRedutoras) == -1){
            UrbemSonata.sonataFieldContainerHide("_codSuplementacaoReducao");
        }
    });

    $(document).on('click', '.money', function () {
        $(this).mask('#.##0,00', {reverse: true});
        $(this).on('change', function () {
            if ($(this).val() == '') {
                $(this).val('0,00');
            }
            if ($(this).val().indexOf(',') < 0) {
                $(this).val($(this).val() + ',00');
            }
        })
    });

    $('.money').on('change', function () {
        if ($(this).val() == '') {
            $(this).val('0,00');
        }
        if ($(this).val().indexOf(',') < 0) {
            $(this).val($(this).val() + ',00');
        }
    });

    $("#filter_leiDecreto_value_autocomplete_input").on("change", function() {
        localStorage.setItem('leiDecretoId', $(this).select2('data').id);
        localStorage.setItem('leiDecretoLabel', $(this).select2('data').label);
    });

    if ($("input[name='filter[leiDecreto][value]']").val()) {
        $("#filter_leiDecreto_value_autocomplete_input").select2('data', {
            id: localStorage.getItem('leiDecretoId'),
            label: localStorage.getItem('leiDecretoLabel')
        });
    }

    localStorage.removeItem('leiDecretoId');
    localStorage.removeItem('leiDecretoLabel');

    $("#filter_dotacao_value_autocomplete_input").on("change", function() {
        localStorage.setItem('dotacaoId', $(this).select2('data').id);
        localStorage.setItem('dotacaoLabel', $(this).select2('data').label);
    });

    if ($("input[name='filter[dotacao][value]']").val()) {
        $("#filter_dotacao_value_autocomplete_input").select2('data', {
            id: localStorage.getItem('dotacaoId'),
            label: localStorage.getItem('dotacaoLabel')
        });
    }

    localStorage.removeItem('dotacaoId');
    localStorage.removeItem('dotacaoLabel');
}());