$(document).ready(function() {
    //ObjectModal
    var modal = $.urbemModal();

    function carregaValoresIniciais() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                if (data.response === true) {
                    if (data.numcgm !== '' && data.nomCgm !== '') {
                        var text = data.numcgm + " - " + data.nomCgm;
                        $("#" + UrbemSonata.uniqId + "_cgm_autocomplete_input").select2("data", {"id": "#" + UrbemSonata.uniqId + "_cgm_autocomplete_input", "label": text}).change();
                        $('input[name^="'+ UrbemSonata.uniqId +'[cgm]"]').val(data.numcgm);
                    }
                }
                modal.close();
            }
        );
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", carregaValoresIniciais);
}());