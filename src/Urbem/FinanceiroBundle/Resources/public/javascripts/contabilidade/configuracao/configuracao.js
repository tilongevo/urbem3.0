$(function () {
    "use strict";

    $("#conta").on("click", function() {
        var caixaEntidadeId = $("#entidades option:selected").val();
        var contaCaixaId = $("#contas option:selected").val();
        var contaCaixaText = $("#contas option:selected").text();
        var contaCaixaArray = contaCaixaText.split(" | ");
        var contaCaixa = contaCaixaArray[contaCaixaArray.length - 1];

        if (contaCaixaText == 'Selecione') {
            return false;
        }

        var linha =
            '<tr>' +
                '<td style=\"display: none\"><input name=\"conta[]\" type=\"hidden\" value=\"' + caixaEntidadeId + '_' + contaCaixaId + '\" /></td>' +
                '<td>' + caixaEntidadeId + '</td>' +
                '<td>' + contaCaixaId + '</td>' +
                '<td>' + contaCaixa + '</td>' +
                '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableContaCaixa').append(linha);
    });

    $("#entidades").on("change", function() {
        var exercicio = $('#exercicio').val();
        var entidade = $(this).val();
        var codEstrutura = '1.1.1.1.1.';

        $("#contas").attr("disabled", true);
        $("#contas")
            .empty()
            .append("<option value=\"\">Selecione</option>");

        $.ajax({
            url: "/financeiro/api/search/planoconta-exercicio-entidade-estrutura?exercicio=" + exercicio
            + "&entidade=" + entidade + "&codEstrutura=" + codEstrutura,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#contas").attr("disabled", false);

                $("#contas")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");
                $.each(data, function (index, value) {
                    $("#contas")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
    });

    $(".remove").click(function() {
        $(this).parent().remove();
    });

    if ($("#" + UrbemSonata.uniqId + "_back_link") != 'undefined') {
        $("a.btn-success").attr('href', $("#" + UrbemSonata.uniqId + "_back_link").val());
    }

    $("#" + UrbemSonata.uniqId + "_cod_contador").prop('disabled', true);
    $("#" + UrbemSonata.uniqId + "_cod_tec_contabil").prop('disabled', true);
    $( "form" ).submit(function( event ) {
        $("#" + UrbemSonata.uniqId + "_cod_contador").prop('disabled', false);
        $("#" + UrbemSonata.uniqId + "_cod_tec_contabil").prop('disabled', false);
    });


}());