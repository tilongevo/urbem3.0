$(function () {
    "use strict";

    $("#assinatura").on("click", function() {
        var entidade = $("#entidade option:selected").val();
        var cgm = $("#cgm option:selected").val();
        var cargo = $("#cargo").val();
        var situacao = $("#situacao").val();
        var cgmText = $("#cgm option:selected").text();
        var situacaoText = $("#situacao option:selected").text();

        if (cargo == '') {
            $("#cargo").css('border', '1px solid red');
            return false;
        }

        var linha =
            '<tr>' +
            '<input name=\"assinaturaTesouraria[]\" type=\"hidden\" value=\"' + entidade + '__' + cgm + '__' + cargo + '__' + situacao + '\" />' +
            '<td>' + cgmText + '</td>' +
            '<td>' + cargo + '</td>' +
            '<td>' + situacaoText + '</td>' +
            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableAssinatura').append(linha);

        $("#cargo").val('');
    });

    $(".remove").on("click", function() {
        $(this).parent().remove();
    });
}());