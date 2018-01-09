$(document).ready(function() {
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
            if (data.codDespesa) {
                $("#" + UrbemSonata.uniqId + "_codDespesa").val(data.codDespesa).change();
            }
        });
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", load);
}());