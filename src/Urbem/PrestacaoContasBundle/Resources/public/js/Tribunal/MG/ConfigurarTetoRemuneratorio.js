$(document).ready(function() {

    $(document).on("change", "#" + UrbemSonata.uniqId + "_teto_remuneratorio_filter_entidade", function() {
        $(".remove-collection").click();

        load($(this).val());
    });

    // disable();

    // ObjectModal
    var modal = $.urbemModal();

    // Function Test
    function load(entidade) {
        modal.disableBackdrop()
            .setTitle("Aguarde")
            .setBody("Buscando informações")
            .open();

        $.post(
            UrlServiceProviderTCE,
            {"entidade": entidade}

        ).success(function (data) {
            modal.close();

            if (false === data.response) {
                return;
            }

            for (var key in data.tetoRemuneratorios) {
                $(".add_collection_link").click();

                $("#" + UrbemSonata.uniqId + "_teto_remuneratorio_filter_registros_dynamic_collection_" + (parseInt(key) + 1) + "_teto").val(data.tetoRemuneratorios[key].teto);
                $("#" + UrbemSonata.uniqId + "_teto_remuneratorio_filter_registros_dynamic_collection_" + (parseInt(key) + 1) + "_vigencia").val(data.tetoRemuneratorios[key].vigencia);
                $("#" + UrbemSonata.uniqId + "_teto_remuneratorio_filter_registros_dynamic_collection_" + (parseInt(key) + 1) + "_justificativa").val(data.tetoRemuneratorios[key].justificativa);
                $("#" + UrbemSonata.uniqId + "_teto_remuneratorio_filter_registros_dynamic_collection_" + (parseInt(key) + 1) + "_evento").val(data.tetoRemuneratorios[key].evento).change();
            }
        });
    }
}());