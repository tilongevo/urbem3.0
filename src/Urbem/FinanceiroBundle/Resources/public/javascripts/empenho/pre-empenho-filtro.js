$(document).ready(function() {
    'use strict';

    var entidade = $('#filter_codEntidade_value'),
        exercicio = $('#filter_exercicio_value'),
        dotacaoOrcamentaria = $('#filter_codDespesa_value');

    if (entidade.val() == undefined) {
        return false;
    }

    if (entidade.val() != '') {
        getDotacao(entidade.val(), exercicio.val());
    }

    entidade.on('change', function () {
        if ($(this).val() == '') {
            clearSelect(dotacaoOrcamentaria);
        } else {
            getDotacao($(this).val(), exercicio.val());
        }
    });

    function getDotacao(codEntidade, exercicio) {
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-dotacao",
            method: "POST",
            data: {
                codEntidade: codEntidade,
                exercicio: exercicio
            },
            dataType: "json",
            success: function (data) {
                var selected = dotacaoOrcamentaria.val();
                clearSelect(dotacaoOrcamentaria);
                $.each(data, function (value, text) {
                    var attrs = {
                        value: value,
                        text: text
                    };
                    if (selected == value) {
                        attrs.selected = true;
                    }
                    dotacaoOrcamentaria.append($('<option>', attrs));
                });
            }
        });
    }

    function clearSelect(field) {
        field.empty().append("<option value=\"\">Selecione</option>").select2('val', '');
    }
}());