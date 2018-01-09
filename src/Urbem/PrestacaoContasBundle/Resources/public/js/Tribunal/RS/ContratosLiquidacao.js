$(document).ready(function() {
    $(".protocolo-numeric").blur(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });
    UrbemSonata.acceptOnlyNumeric($(".protocolo-numeric"));

    function onLoadClickEnableSelect2InPage() {
        $(".add_collection_link").on("click", function() {
            $("select.select2-parameters").select2();;
        });
    }

    // Onload
    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", onLoadClickEnableSelect2InPage);
}());