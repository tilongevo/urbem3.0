(function() {
    'use strict';

    $("#" + UrbemSonata.uniqId + "_codGrupo").prop("readonly", true);

    $("#" + UrbemSonata.uniqId + "_codNatureza").on("change", function() {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando grupos</h4>');
        $("#" + UrbemSonata.uniqId + "_codGrupo").empty();
        $("#" + UrbemSonata.uniqId + "_codGrupo").prop("readonly", true);
        $('select').select2();
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/patrimonio/manutencao/consultar-grupo/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_codGrupo")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_codGrupo")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
                $("#" + UrbemSonata.uniqId + "_codGrupo").prop("readonly", false);
                $('select').select2();
                fechaModal();
            }
        });
        if ($(this).find(":selected").val() != undefined) {
            $('#' + UrbemSonata.uniqId + '_classificacao').val($(this).find(":selected").val());
        }
    });


    if(!$("#filter_fkPatrimonioGrupo_value").hasClass('grupoDestravado'))
    {
        $("#filter_fkPatrimonioGrupo_value").prop("readonly", true);
    }
    $("#filter_fkPatrimonioGrupo__fkPatrimonioNatureza_value").on("change", function() {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando grupos</h4>');
        $("#filter_fkPatrimonioGrupo_value").empty();
        $("#filter_fkPatrimonioGrupo_value").prop("readonly", true);
        $('select').select2();
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/patrimonio/manutencao/consultar-grupo/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#filter_fkPatrimonioGrupo_value")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#filter_fkPatrimonioGrupo_value")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
                $("#filter_fkPatrimonioGrupo_value").prop("readonly", false);
                $('select').select2();
                fechaModal();
            }
        });
        if ($(this).find(":selected").val() != undefined) {
            $('#' + UrbemSonata.uniqId + '_classificacao').val($(this).find(":selected").val());
        }
    });
}());