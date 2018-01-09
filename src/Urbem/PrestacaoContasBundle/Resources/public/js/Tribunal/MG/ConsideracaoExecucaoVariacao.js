$(document).ready(function() {
    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    /*Adiciona o Botão, após o Input Exercicio*/
    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_codMes");
    containerFields.after(areaButton);

    //Desabilita o form
    disableForm(toolTipConsideracaoExecucaoVariacao);

    /*Escuta botão de busca*/
    $("#btnSearch").on("click", function() {
        buscaParametros();
        enableForm(toolTipConsideracaoExecucaoVariacao);
    });

    // Add Tooltip on Inputs
    $.each(toolTipConsideracaoExecucaoVariacao, function(index, value) {
        if  ($("#" + UrbemSonata.uniqId + "_" + index).length) {
            var input = $("#" + UrbemSonata.uniqId + "_" + index);
            input.attr("data-toggle", "tooltip")
                .attr("data-html", "true")
                .attr("title", value);
        }
    });

     //ObjectModal
    var modal = $.urbemModal();

    // Function Test
    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                    var count = 0;
                    if (data.response == true) {
                        $.each(data, function(index, value) {
                            if ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                                if (index != 'codMes') {
                                    $("#" + UrbemSonata.uniqId + "_" + index).val(value);
                                }
                            }
                            count++;
                        });
                    }
                    if (count <= 1) {
                        clearInputs(toolTipConsideracaoExecucaoVariacao);
                    }
                    modal.close();
                }
            );
    }

    /**
     *
     * @param fieldsName
     */
    function clearInputs(fieldsName) {
        $.each(fieldsName, function (index) {
            if ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                input.val('');
            }
        })
    }
    /**
     *
     * @param fieldsName
     */
    function disableForm(fieldsName)
    {
        $.each(fieldsName, function (index) {
            if ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                input.prop('disabled', true);
            }
        });
        $(':input[type=submit]').prop('disabled', true);
    }

    /**
     *
     * @param fieldsName
     */
    function enableForm(fieldsName)
    {
        $.each(fieldsName, function (index) {
            if ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                input.prop('disabled', false);
            }
        });
        $(':input[type=submit]').prop('disabled', false);
    }
}());