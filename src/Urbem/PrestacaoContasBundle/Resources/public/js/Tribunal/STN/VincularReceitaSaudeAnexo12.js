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
            for (var key in data.receitas) {
                $(".add_collection_link").click();

                $("#" + UrbemSonata.uniqId + "_stn_vincular_receita_saude_anexo_12_receitas_dynamic_collection_" + (parseInt(key) + 1) + "_exercicio").val(data.receitas[key].exercicio);
                $("#" + UrbemSonata.uniqId + "_stn_vincular_receita_saude_anexo_12_receitas_dynamic_collection_" + (parseInt(key) + 1) + "_codReceita_autocomplete_input").select2("data", {"id": data.receitas[key].codReceita, "label": data.receitas[key].descricao}).change();
                $("input[name='" + UrbemSonata.uniqId + "[stn_vincular_receita_saude_anexo_12][receitas][dynamic_collection][" + (parseInt(key) + 1) + "][codReceita]']").val(data.receitas[key].codReceita);
            }
        });
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", load);
}());