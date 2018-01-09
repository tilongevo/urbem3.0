$(document).ready(function() {
    $(".protocolo-numeric").blur(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });
    UrbemSonata.acceptOnlyNumeric($(".protocolo-numeric"));

    // Fields
    var codMuncipioInput = $("#" + UrbemSonata.uniqId + "_inCodMunicipio");
    var opcaoSemestralidade = $("select#" + UrbemSonata.uniqId + "_inOpcaoSemestralidade");


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
                        codMuncipioInput.val(data.inCodMunicipio);
                        if (data.inOpcaoSemestralidade) {
                            opcaoSemestralidade.val(data.inOpcaoSemestralidade).trigger("change");
                        }
                    }
                    modal.close();
                }
            );
    }

    // Onload
    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", carregaValoresIniciais);
}());