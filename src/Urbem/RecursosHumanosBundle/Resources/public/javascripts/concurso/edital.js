function atualizarCampos(codNorma) {
    $.ajax({
        url: "/recursos-humanos/concurso/edital/consultar-dados-edital",
        method: "POST",
        data: {
            codNorma: codNorma
        },
        dataType: "json",
        success: function (data) {
            var codNorma_value = $("#edital_editalAbertura option:selected").val(),
            codNorma_text = $("#edital_editalAbertura option:selected").text();

            $("#edital_lbldtPublicacao").val(data.dtPublicacao);
            $("#edital_spnlinkEdital").val(data.link);
            $("#edital_stTipoNorma").val(data.codTipoNorma);
            $("#edital_inCodTipoNorma").val(data.codTipoNorma);

            $("#edital_codNorma")
            .empty()
            .append("<option value=\"\">Selecione</option>")
            .append("<option selected value=" + codNorma_value + ">" + codNorma_text + "</option>");
            $('select').material_select();
            Materialize.updateTextFields();
        }
    });
}

function atualizarNormaRegulamentadora(tiponorma) {
    $.ajax({
        url: "/recursos-humanos/concurso/edital/consultar-normas-tipo-norma",
        method: "POST",
        data: {
            tiponorma: tiponorma
        },
        dataType: "json",
        success: function (data) {
            $("#edital_stNorma")
            .empty()
            .append("<option value=\"\">Selecione</option>");

            for (var i = 0; i < data.length; i++) {
                $("#edital_stNorma")
                .append("<option value=" + data[i].codNorma + ">" + data[i].nomNorma + "</option>");
            }
            $('select').material_select();
        }
    });
}

function consultarNormasPorTipo(source_field, target_field) {
    $.ajax({
        url: "/recursos-humanos/concurso/edital/consultar-normas-tipo-norma",
        method: "POST",
        data: {
            tiponorma: source_field.val()
        },
        dataType: "json",
        success: function (data) {
            target_field
            .empty()
            .append("<option value=\"\">Selecione</option>");

            for (var i = 0; i < data.length; i++) {
                target_field
                .append("<option value=" + data[i].codNorma + ">" + data[i].nomNorma + "</option>");
            }
            $('select').material_select();
        }
    });
}

$(function() {
    $("#edital_inCodTipoNorma").on("change", function() {
        consultarNormasPorTipo($(this), $("#edital_codNorma"));
    });

    atualizarCampos($("#edital_editalAbertura").val());
    $("#edital_editalAbertura").on("change", function() {
        atualizarCampos($(this).val());
    });

    // $("#edital_stTipoNorma").on("change", function() {
    //     atualizarNormaRegulamentadora($(this).val());
    // });
});
