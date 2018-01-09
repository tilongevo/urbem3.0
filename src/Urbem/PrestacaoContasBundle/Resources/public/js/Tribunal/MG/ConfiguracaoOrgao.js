$(document).ready(function() {
    // Fields
    var inCodigo = $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_inCodigo");
    var inNumUnidade = $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_inNumUnidade");

    function disable() {
        inCodigo.val("").prop("disabled", true);
        inNumUnidade.val("").change().prop("disabled", true);

        $(".remove-collection").click();
    }

    $(document).on("change", "#" + UrbemSonata.uniqId + "_configuracao_orgao_type_inCodEntidade", function() {
        disable();

        load($(this).val());
    });

    disable();

    // ObjectModal
    var modal = $.urbemModal();

    // Function Test
    function load(inCodEntidade) {
        modal.disableBackdrop()
            .setTitle("Aguarde")
            .setBody("Buscando informações")
            .open();

        $.post(
            UrlServiceProviderTCE,
            {"inCodEntidade": inCodEntidade}

        ).success(function (data) {
            modal.close();

            if (false === data.response) {
                return;
            }

            inCodigo.val(data.inCodigo).prop("disabled", false);
            inNumUnidade.val(data.inNumUnidade).prop("disabled", false).change();

            for (var key in data.responsaveis) {
                $(".add_collection_link").click();

                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_inNumCGM_autocomplete_input").select2("data", {"id": data.responsaveis[key].inNumCGM, "label": data.responsaveis[key].stNumCGM}).change();
                $("input[name='" + UrbemSonata.uniqId + "[configuracao_orgao_type][responsaveis][dynamic_collection][" + (parseInt(key) + 1) + "][inNumCGM]']").val(data.responsaveis[key].inNumCGM);
                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_inTipoResponsavel").val(data.responsaveis[key].inTipoResponsavel).change();
                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_stCargoGestor").val(data.responsaveis[key].stCargoGestor);
                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_stCRCContador").val(data.responsaveis[key].stCRCContador);
                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_stSiglaUF").val(data.responsaveis[key].stSiglaUF).change();
                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_dtInicio").val(data.responsaveis[key].dtInicio);
                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_dtFim").val(data.responsaveis[key].dtFim);
                $("#" + UrbemSonata.uniqId + "_configuracao_orgao_type_responsaveis_dynamic_collection_" + (parseInt(key) + 1) + "_stEMail").val(data.responsaveis[key].stEMail);
            }
        });
    }
}());