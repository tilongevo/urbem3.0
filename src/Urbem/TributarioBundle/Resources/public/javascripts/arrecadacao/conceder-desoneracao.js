var vincularDesoneracao = $("#" + UrbemSonata.uniqId + "_vincularDesoneracao"),
    inscricaoEconomica = $("#" + UrbemSonata.uniqId + "_inscricaoEconomica"),
    inscricaoImobiliaria = $("#" + UrbemSonata.uniqId + "_inscricaoImobiliaria"),
    numcgm = $("#" + UrbemSonata.uniqId + "_fkSwCgm_autocomplete_input"),
    fkArrecadacaoDesoneracao = $("#" + UrbemSonata.uniqId + "_fkArrecadacaoDesoneracao");

inscricaoEconomica.attr('disabled', true);
inscricaoImobiliaria.attr('disabled', true);

$("button[name='btn_create_and_list']").hide();

fkArrecadacaoDesoneracao.on("change", function () {
    var params = {
        entidade: "CoreBundle:Arrecadacao\\AtributoDesoneracao",
        fkEntidadeAtributoValor: "getFkArrecadacaoAtributoDesoneracaoValores",
        codModulo: "25",
        codCadastro: "3",
        codEntidade: {
            codDesoneracao: fkArrecadacaoDesoneracao.val()
        }
    };

    AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
});

vincularDesoneracao.on("click", function() {
    $("#spinner").show();

    $('.sonata-ba-field-error-messages').remove();

    if (numcgm.parent().hasClass('sonata-ba-field-error')) {
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkSwCgm_autocomplete_input').removeClass('has-error');
    }

    if (numcgm.val() == '') {
        UrbemSonata.setFieldErrorMessage('numcgm', 'Selecione um CGM antes de continuar!', numcgm.parent());
        return false;
    }

    var modalErro = new UrbemModal();
    modalErro.setTitle('Conceder Desoneração');

    if (vincularDesoneracao.val() == 'II') {
        inscricaoEconomica.attr('disabled', true);
        inscricaoImobiliaria.attr('disabled', true);
        $.ajax({
            url: "/tributario/arrecadacao/desoneracao/conceder-desoneracao/busca-cadastro-imobiliario",
            method: "GET",
            data: {
                numcgm: numcgm.val()
            },
            dataType: "json",
            success: function (data) {
                if (Object.keys(data).length == 0) {
                    modalErro.setContent('Não há inscrição imobiliária vinculada a este CGM.');
                    modalErro.open();
                } else {
                    inscricaoImobiliaria.attr('disabled', false);
                    inscricaoImobiliaria
                        .empty()
                        .append("<option value=\"Selecione\">Selecione</option>");

                    $.each(data, function (index, value) {
                        console.log(index + " - " + value);
                        inscricaoImobiliaria.append("<option value=" + index + ">" + value + "</option>");
                    });

                    $("button[name='btn_create_and_list']").show();
                }
            }
        });
    } else if (vincularDesoneracao.val() == 'IE') {
        inscricaoEconomica.attr('disabled', true);
        inscricaoImobiliaria.attr('disabled', true);
        $.ajax({
            url: "/tributario/arrecadacao/desoneracao/conceder-desoneracao/busca-cadastro-economico",
            method: "GET",
            data: {
                numcgm: numcgm.val()
            },
            dataType: "json",
            success: function (data) {
                if (Object.keys(data).length == 0) {
                    modalErro.setContent('Não há inscrição econômica vinculada a este CGM.');
                    modalErro.open();
                } else {
                    inscricaoEconomica.attr('disabled', false);
                    inscricaoEconomica
                        .empty()
                        .append("<option value=\"\">Selecione</option>");

                    $.each(data, function (index, value) {
                        inscricaoEconomica.append("<option value=" + index + ">" + value + "</option>");
                    });
                    $("button[name='btn_create_and_list']").show();
                }
            }
        });
    }
});