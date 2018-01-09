$(function () {
    "use strict";

    var natureza = $('#' + UrbemSonata.uniqId + '_natureza').find(":selected").val();
    var grupo = $('#' + UrbemSonata.uniqId + '_grupo').find(":selected").val();
    var especie = $('#' + UrbemSonata.uniqId + '_especie').find(":selected").val();
    var inputBem = UrbemSonata.giveMeBackMyField('fkPatrimonioBem');
    var inputNumPlaca = UrbemSonata.giveMeBackMyField('numPlaca');
    var inputCodNatureza = UrbemSonata.giveMeBackMyField('codNatureza');
    var inputCodGrupo = UrbemSonata.giveMeBackMyField('codGrupo');
    var inputCodEspecie = UrbemSonata.giveMeBackMyField('codEspecie')
        , modal = jQuery.urbemModal();

    $("#" + UrbemSonata.uniqId + "_natureza").on("change", function() {
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/patrimonio/manutencao/consultar-grupo/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_grupo")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_grupo")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
        $('#' + UrbemSonata.uniqId + '_classificacao').val($(this).find(":selected").val());
    });

    $("#" + UrbemSonata.uniqId + "_grupo").on("change", function() {
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/patrimonio/manutencao/consultar-especie/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_especie")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_especie")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });

        var natureza = $('#' + UrbemSonata.uniqId + '_natureza').find(":selected").val();
        $('#' + UrbemSonata.uniqId + '_classificacao').val(natureza + '.' + $(this).find(":selected").val());
    });

    $("#" + UrbemSonata.uniqId + "_especie").on("change", function() {
        var id = $(this).val();
        console.log(id);
        $.ajax({
            url: "/patrimonial/patrimonio/manutencao/consultar-bem/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_codBem")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_codBem")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });

        var natureza = $('#' + UrbemSonata.uniqId + '_natureza').find(":selected").val();
        var grupo = $('#' + UrbemSonata.uniqId + '_grupo').find(":selected").val();
        $('#' + UrbemSonata.uniqId + '_classificacao').val(natureza  + '.' + grupo + '.'  + $(this).find(":selected").val());
    });

    $("#" + UrbemSonata.uniqId + "_codBem").on("change", function() {
        var id = $(this).val();

        $.ajax({
            url: "/patrimonial/patrimonio/bem/consultar-bem/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $('#' + UrbemSonata.uniqId + '_nomePlaca').val(data.numPlaca);

            }
        });
    });

    if(inputBem) {
        inputBem.on("change", function () {
            var id = $(this).val();

            $.ajax({
                url: "/patrimonial/patrimonio/bem/consultar-bem/" + id,
                method: "GET",
                dataType: "json",
                beforeSend: function (xhr) {
                    modal
                        .disableBackdrop()
                        .setTitle('Aguarde...')
                        .setBody('Carregando dados do bem.')
                        .open();
                },
                success: function (data) {
                    inputNumPlaca.val(data.numPlaca);
                    inputCodNatureza.val(data.natureza);
                    inputCodGrupo.val(data.grupo);
                    inputCodEspecie.val(data.especie);

                    modal.close();
                }
            });
        });
    }

    if(inputBem && inputBem.val() != '') {
        inputBem.trigger('change');
    }

}());
