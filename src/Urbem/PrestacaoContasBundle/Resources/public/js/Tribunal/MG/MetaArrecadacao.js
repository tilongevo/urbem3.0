$(document).ready(function() {
    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    /*Adiciona o Botão, após o Input Descricao*/
    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_mes");
    containerFields.after(areaButton);

    disableForm();

    /*Escuta botão de busca*/
    $("#btnSearch").on("click", function() {
        buscaParametros();
        enableForm();
    });

    /*Limpa o Textarea e Desabilita a observacao e o submit obrigando uma nova search*/
    $(document).on("change", "#" + UrbemSonata.uniqId + "_mes", function() {
        disableForm();
        $('textarea').val('');
    });

    //ObjectModal
    var modal = $.urbemModal();

    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                if (data.response == true) {
                    var observacao = $("#" + UrbemSonata.uniqId + "_observacao");
                    observacao.val(data.observacao);
                }
                modal.close();
                }
            );
    }

    function disableForm()
    {
        $('textarea').prop('disabled', true);
        $(':input[type=submit]').prop('disabled', true);
    }

    function enableForm()
    {
        $('textarea').prop('disabled', false);
        $(':input[type=submit]').prop('disabled', false);
    }
}());