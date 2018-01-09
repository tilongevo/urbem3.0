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
            for (var key in data.receita) {
                $(".add_collection_link").click();

                $("#" + UrbemSonata.uniqId + "_stn_configuracao_anexo_3_rcl_registros_dynamic_collection_" + (parseInt(key) + 1) + "_exercicio").val(data.receita[key].exercicio);
                $("#" + UrbemSonata.uniqId + "_stn_configuracao_anexo_3_rcl_registros_dynamic_collection_" + (parseInt(key) + 1) + "_codReceita_autocomplete_input").select2("data", {"id": data.receita[key].codReceita, "label": data.receita[key].descricao}).change();
                $("input[name='" + UrbemSonata.uniqId + "[stn_configuracao_anexo_3_rcl][registros][dynamic_collection][" + (parseInt(key) + 1) + "][codReceita]']").val(data.receita[key].codReceita);
                $("#" + UrbemSonata.uniqId + "_stn_configuracao_anexo_3_rcl_registros_dynamic_collection_" + (parseInt(key) + 1) + "_codTipo").val(data.receita[key].codTipo).change();
            }
        });
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", load);
}());