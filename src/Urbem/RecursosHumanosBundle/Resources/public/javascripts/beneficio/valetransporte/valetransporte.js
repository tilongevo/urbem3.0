$(function () {
    "use strict";
    
    $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_ufOrigem").on("change", function() {
        if ($(this).val() == '') {
            $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioOrigem")
                .empty()
                .append("<option value=\"\">Selecione</option>");
            return false;
        }
        $.ajax({
            url: "/recursos-humanos/beneficio/vale-transporte/consultar-municipio-uf/" + $(this).val(),
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioOrigem")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioOrigem")
                        .append("<option value=" + i + ">" + data[i] + "</option>");
                }

                $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioOrigem")
                    .val("").trigger("change");
            }
        });
    });

    $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_ufDestino").on("change", function() {
        if ($(this).val() == '') {
            $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioDestino")
                .empty()
                .append("<option value=\"\">Selecione</option>");
            return false;
        }

        $.ajax({
            url: "/recursos-humanos/beneficio/vale-transporte/consultar-municipio-uf/" + $(this).val(),
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioDestino")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioDestino")
                        .append("<option value=" + i + ">" + data[i] + "</option>");
                }

                $("#" + UrbemSonata.uniqId + "_fkBeneficioItinerario_municipioDestino")
                    .val("").trigger("change");
            }
        });
    });
}());
