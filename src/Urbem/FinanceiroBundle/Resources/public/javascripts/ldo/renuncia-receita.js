$(document).ready(function() {
    'use strict';

    function getExercicioLdo(inCodPPA, target) {
        $("#filter_ldoAno_value").attr('disabled', true);
        if (! inCodPPA ) {
            target
                .empty()
                .append("<option value=\"\">Selecione</option>")
                .select2("val", "");;
            return false;
        }

        $.ajax({
            url: "/financeiro/ldo/renuncia-receita/get-exercicio-ldo",
            method: "POST",
            data: {
              inCodPPA: inCodPPA
            },
            dataType: "json",
            success: function (data) {
                var selected = target.val();
                target
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    if (selected == i) {
                        target.append("<option value=" + i + " selected>" + data[i] + "</option>");
                    } else {
                        target.append("<option value=" + i + ">" + data[i] + "</option>");
                    }

                    if (i == $("#" + UrbemSonata.uniqId + "_inAnoLdoOriginal").val()) {
                        target.val(i).trigger("change");
                    }
                }

                target.select2("val", selected);
                $("#filter_ldoAno_value").attr('disabled', false);
            }
        });
    }
    $("#" + UrbemSonata.uniqId + "_codPpa").on("change", function () {
        getExercicioLdo($(this).val(), $("#" + UrbemSonata.uniqId + "_ano"));
    });

    $("#filter_ldoAno_value").attr('disabled', true);
    $("#filter_fkLdoLdo__fkPpaPpa_value").on("change", function () {
        getExercicioLdo($(this).val(), $("#filter_ldoAno_value"));
    });

    $("#filter_fkLdoLdo__fkPpaPpa_value").trigger("change");
}());
