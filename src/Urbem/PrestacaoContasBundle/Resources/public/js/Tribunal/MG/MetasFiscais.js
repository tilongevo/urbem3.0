$(document).ready(function() {
    $(".protocolo-numeric").blur(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });
    UrbemSonata.acceptOnlyNumeric($(".protocolo-numeric"));

    // Add Tooltip on Inputs
    $.each(toolTipMetasFiscais, function(index, value) {
        if  ($("#" + UrbemSonata.uniqId + "_" + index).length) {
            var input = $("#" + UrbemSonata.uniqId + "_" + index);
            input.attr("data-toggle", "tooltip")
                .attr("data-html", "true")
                .attr("title", value);
        }
    });

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
                        $.each(data, function(index, value) {
                            if  ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                                input.val(value);
                            }
                        });
                    }
                    modal.close();
                }
            );
    }

    // Onload
    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", carregaValoresIniciais);

}());