$(document).ready(function() {
    'use strict';

    function getExercicioLdo(inCodPPA, target) {
        $.ajax({
            url: "/financeiro/ldo/validacao-acoes/get-exercicio-ldo",
            method: "POST",
            data: {
              inCodPPA: inCodPPA
            },
            dataType: "json",
            success: function (data) {
                target
                    .empty()
                    .append("<option value=\"\">Selecione</option>")

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                target.select2("val", "");
            }
        });
    }

    $("#filter_inCodPPATxt_value").on("change", function () {
        getExercicioLdo($(this).val(), $("#filter_slExercicioLDO_value"));
    });

    $("#filter_inCodPPATxt_value").trigger("change");
}());
