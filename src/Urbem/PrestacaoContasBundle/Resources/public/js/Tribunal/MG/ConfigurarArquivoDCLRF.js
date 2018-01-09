$(document).ready(function() {
    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="search-parametros-uniorcam white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    /*Adiciona o Botão, após o Input Exercicio*/
    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_exercicio");
    containerFields.after(areaButton);

    var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio");

    //Seta o maxlength no exercicio
    exercicio.attr('maxlength','4');

    //Desabilita o form
    disableForm(toolTipArquivoDclrf);

    exercicio.keyup(function() {
        if (isValid(exercicio)) {
            $("#btnSearch").prop('disabled', false);
        } else {
            disableForm(toolTipArquivoDclrf);
        }
    });

    /*Escuta botão de busca*/
    $(".search-parametros-uniorcam").on("click", function() {
        buscaParametros();
        enableForm(toolTipArquivoDclrf);
    });

    // Add Tooltip on Inputs
    $.each(toolTipArquivoDclrf, function(index, value) {
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
                    if (data.response == true) {
                        $.each(data, function(index, value) {
                            if ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                                if (index == 'bimestre' || index == 'metaBimestral' || index == 'publicacaoRelatorioLrf') {
                                    var combo = $("select#" + UrbemSonata.uniqId + "_" + index);
                                    combo.val(value).trigger("change");
                                } else {
                                    var input = $("#" + UrbemSonata.uniqId + "_" + index);
                                    input.val(value);
                                }
                            }
                        });
                    }
                    modal.close();
                }
            );
    }

    /**
     *
     * @param exercicio
     * @returns {boolean}
     */
    function isValid(exercicio)
    {
        return (exercicio.val().replace(/ /g,'').length == 4);
    }

    /**
     *
     * @param tipoArquivoDclrfEnum
     */
    function disableForm(tipoArquivoDclrfEnum)
    {
        $.each(tipoArquivoDclrfEnum, function (index) {
            if ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                input.prop('disabled', true);
            }
        });
        $("#btnSearch").prop('disabled', true);
        $(':input[type=submit]').prop('disabled', true);
    }

    /**
     *
     * @param tipoArquivoDclrfEnum
     */
    function enableForm(tipoArquivoDclrfEnum)
    {
        $.each(tipoArquivoDclrfEnum, function (index) {
            if ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                input.prop('disabled', false);
            }
        });
        $(':input[type=submit]').prop('disabled', false);
    }
}());