$(document).ready(function() {
    $(".remove-collection").click();

    // ObjectModal
    var modal = $.urbemModal();

    function load() {
        modal.disableBackdrop()
            .setTitle("Aguarde")
            .setBody("Buscando informações")
            .open();

        $.post(
            UrlServiceProviderTCE

        ).success(function (data) {
            modal.close();

            if (false === data.response) {
                return;
            }

            $(".remove-collection").click();
            for (var key in data.notas) {
                $(".add_collection_link").click();

                $("#" + UrbemSonata.uniqId + "_stn_manter_notas_explicativas_itens_dynamic_collection_" + (parseInt(key) + 1) + "_anexo").val(data.notas[key].codAcao).change();
                $("#" + UrbemSonata.uniqId + "_stn_manter_notas_explicativas_itens_dynamic_collection_" + (parseInt(key) + 1) + "_dataInicial").val(data.notas[key].dataInicial);
                $("#" + UrbemSonata.uniqId + "_stn_manter_notas_explicativas_itens_dynamic_collection_" + (parseInt(key) + 1) + "_dataFinal").val(data.notas[key].dataFinal);
                $("#" + UrbemSonata.uniqId + "_stn_manter_notas_explicativas_itens_dynamic_collection_" + (parseInt(key) + 1) + "_notaExplicativa").val(data.notas[key].notaExplicativa);
            }
        });
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", load);
}());