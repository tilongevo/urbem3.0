$(document).ready(function() {
    $(".protocolo-numeric").blur(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });
    UrbemSonata.acceptOnlyNumeric($(".protocolo-numeric"));

    // Fields
    var codExecutivoInput = $("#" + UrbemSonata.uniqId + "_inCodExecutivo");
    var codLegislativoInput = $("#" + UrbemSonata.uniqId + "_inCodLegislativo");
    var codRPPSInput = $("#" + UrbemSonata.uniqId + "_inCodRPPS");
    var codOutrosInput = $("#" + UrbemSonata.uniqId + "_inCodOutros");

    // ObjectModal
    var modal = $.urbemModal();

    // Function Test
    function carregaValoresIniciais() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                    if (data.response == true) {
                        codExecutivoInput.val(data.inCodExecutivo);
                        codLegislativoInput.val(data.inCodLegislativo);
                        codRPPSInput.val(data.inCodRPPS);
                        codOutrosInput.val(data.inCodOutros);
                    }
                    modal.close();
                }
            );
    }

    // Onload
    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", carregaValoresIniciais);
}());