$(document).ready(function() {
    function onLoadClickEnableSelect2InPage() {
        $(".add_collection_link").on("click", function() {
            $("select.select2-parameters").select2();;
        });
    }

    // Onload
    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", onLoadClickEnableSelect2InPage);
}());