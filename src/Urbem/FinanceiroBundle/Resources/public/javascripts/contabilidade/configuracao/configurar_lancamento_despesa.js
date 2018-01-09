$(function () {
    "use strict";

    $("#" + UrbemSonata.uniqId + "_despesaFiltro").attr("disabled", true);

    $("#" + UrbemSonata.uniqId + "_debitoLiquidacaoLancamento").attr("disabled", true);
    $("#" + UrbemSonata.uniqId + "_creditoLiquidacaoLancamento").attr("disabled", true);

    $("#" + UrbemSonata.uniqId + "_listaDespesaFiltro").on("change", function() {
        var descricao = $("#" + UrbemSonata.uniqId + "_listaDespesaFiltro option:selected").text();
        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        var mascaraArray = descricao.split("-");
        var mascara = mascaraArray[0].trim();
        var modulo = 8;

        $.ajax({
            url: "/financeiro/api/search/conta-despesa-mascara-exercicio-modulo?mascara=" + mascara
                + "&exercicio=" + exercicio + "&modulo=" + modulo,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_despesaFiltro").attr("disabled", false);

                $("#" + UrbemSonata.uniqId + "_despesaFiltro")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_despesaFiltro")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });

    $("#" + UrbemSonata.uniqId + "_lancamento").on("change", function() {
        var opcao = $(this).val();
        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();

        $.ajax({
            url: "/financeiro/api/search/conta-despesa-tipo-exercicio?tipo=" + opcao + "&exercicio=" + exercicio,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_debitoLiquidacaoLancamento").attr("disabled", false);

                $("#" + UrbemSonata.uniqId + "_debitoLiquidacaoLancamento")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data.debitoLiquidacaoLancamentoList, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_debitoLiquidacaoLancamento")
                        .append("<option value=" + value.cod_conta + ">" + value.cod_estrutural + ' - ' + value.nom_conta + "</option>");
                });

                $("#" + UrbemSonata.uniqId + "_creditoLiquidacaoLancamento").attr("disabled", false);

                $("#" + UrbemSonata.uniqId + "_creditoLiquidacaoLancamento")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data.creditoLiquidacaoLancamentoList, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_creditoLiquidacaoLancamento")
                        .append("<option value=" + value.cod_conta + ">" + value.cod_estrutural + ' - ' + value.nom_conta + "</option>");
                });
            }
        });

    });
    $('.form-control:eq(3)').css('width', '22%');
    $('.box-header:eq(3)').css('margin-top', '25px');
}());