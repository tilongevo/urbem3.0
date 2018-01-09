$(document).ready(function() {

    // ObjectModal
    var modal = $.urbemModal();

    function loadRiscosFicais() {
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
            var riscos = data.riscos;

            for (var key in data.riscos) {
                $(".add_collection_link").click();

                $("#" + UrbemSonata.uniqId + "_stn_identificador_riscos_fiscais_registros_dynamic_collection_" + (parseInt(key) + 1) + "_entidade").select2("val", data.riscos[key].entidades);
                $("#" + UrbemSonata.uniqId + "_stn_identificador_riscos_fiscais_registros_dynamic_collection_" + (parseInt(key) + 1) + "_descricao").val(data.riscos[key].descricao);
                $("#" + UrbemSonata.uniqId + "_stn_identificador_riscos_fiscais_registros_dynamic_collection_" + (parseInt(key) + 1) + "_codIdentificador").val(data.riscos[key].codIdentificador).change();
                $("#" + UrbemSonata.uniqId + "_stn_identificador_riscos_fiscais_registros_dynamic_collection_" + (parseInt(key) + 1) + "_valor").val(UrbemSonata.convertFloatToMoney(data.riscos[key].valor));
            }
        });
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", loadRiscosFicais);
}());