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
            for (var key in data.contas) {
                $(".add_collection_link").click();

                $("#" + UrbemSonata.uniqId + "_stn_vincular_conta_fundeb_contas_dynamic_collection_" + (parseInt(key) + 1) + "_entidade").val(data.contas[key].entidade).change();
                $("#" + UrbemSonata.uniqId + "_stn_vincular_conta_fundeb_contas_dynamic_collection_" + (parseInt(key) + 1) + "_codPlano_autocomplete_input").select2("data", {"id": data.contas[key].codPlano, "label": data.contas[key].descricao}).change();
                $("input[name='" + UrbemSonata.uniqId + "[stn_vincular_conta_fundeb][contas][dynamic_collection][" + (parseInt(key) + 1) + "][codPlano]']").val(data.contas[key].codPlano);
            }
        });
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", load);
}());