$(document).ready(function() {
    'use strict';
    
    function getUnidadeOrcamentaria(source, target) {
        if (source.val() == '') {
            return false;
        }

        $.ajax({
            url: "/financeiro/empenho/consultar-empenho/get-unidade-num-orgao",
            method: "POST",
            data: {
                exercicio: $("#filter_exercicio_value").val(),
                numOrgao: source.val()
            },
            dataType: "json",
            success: function (data) {
                target
                    .empty()
                    .append("<option value=\"\">Selecione</option>")

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.val('').trigger("change");
            }
        });
    }
    
    $("#filter_numOrgao_value").on("change", function () {
        getUnidadeOrcamentaria($(this), $("#filter_numUnidade_value"));
    });
});
