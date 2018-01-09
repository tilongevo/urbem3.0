$(document).ready(function() {

    var btnSubmit = $(':input[type=submit]');
    var buttonSearch = $('<button type="button" class="white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">input</i>Ok</button>');
    btnSubmit.after(buttonSearch);
    btnSubmit.remove();

    $(document).on("change", "#" + UrbemSonata.uniqId + "_requisito_cargo_filter_entidade", function() {
        $(".remove-collection").click();
        if ($(this).val()) {
            load($(this).val());
        }
    });

    $(".save").on('click', function (e) {

        modal.disableBackdrop()
            .setTitle("Aguarde")
            .setBody("Validando Dados")
            .open();

        data = $("form").serializeArray();
        data.push({name: "action", value:"ValidateRequisitosCargo"});

        $.post(
            UrlServiceProviderTCE, data
        ).success(function (data) {
            modal.close().remove();
            if (false === data.response) {
                modal.disableBackdrop()
                    .showCloseButton()
                    .setTitle("Erro")
                    .setBody(data.message)
                    .open();
            } else {
                $("form").submit();
            }
        });
    });

    // ObjectModal
    var modal = $.urbemModal();

    function load(entidade) {
        modal.disableBackdrop()
            .setTitle("Aguarde")
            .setBody("Buscando informações")
            .open();

        data = [];
        data.push({name: "action", value: "LoadRequisitoCargo"});
        data.push({name: "entidade", value: entidade});
        $.post(
            UrlServiceProviderTCE, data
        ).success(function (data) {
            modal.close().remove();

            if (false === data.response) {
                $("#" + UrbemSonata.uniqId + "_requisito_cargo_filter_entidade").val('').change();
                modal.disableBackdrop()
                    .showCloseButton()
                    .setTitle("Erro")
                    .setBody(data.message)
                    .open();
                return;
            }

            var content = data.content;
            key = 1;
            $.each(content, function (codTipo, items) {
                $(".add_collection_link").click();
                $("#" + UrbemSonata.uniqId + "_requisito_cargo_filter_registros_dynamic_collection_" + key + "_requisito").val(codTipo).change();
                $("#" + UrbemSonata.uniqId + "_requisito_cargo_filter_registros_dynamic_collection_" + key + "_cargo").select2('val', items.cod_cargo);
                key++;
            });
        });
    }
}());