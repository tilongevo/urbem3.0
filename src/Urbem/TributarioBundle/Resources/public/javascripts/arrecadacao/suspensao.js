$(function () {
    "use strict";

    var classificacao = UrbemSonata.giveMeBackMyField('fkSwClassificacao'),
        assunto = UrbemSonata.giveMeBackMyField('fkSwAssunto'),
        processo = $("#" + UrbemSonata.uniqId + "_fkSwProcesso_autocomplete_input");

    if (classificacao.val() == '') {
        assunto.attr('disabled', true);
        processo.select2('disable');
    }

    window.varJsCodClassificacao = classificacao.val();
    classificacao.on("change", function() {
        if ($(this).val() != '') {
            processo.select2('enable');
            carregaAssunto($(this).val());
        } else {
            clearSelect(assunto, true);
            assunto.attr('disabled', true);
            processo.select2('val', '');
            processo.select2('disable');
        }
        window.varJsCodClassificacao = $(this).val();
    });

    window.varJsCodAssunto = assunto.val();
    assunto.on("change", function() {
        window.varJsCodAssunto = $(this).val();
    });

    function clearSelect(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append('<option value="">Selecione</option>');
        }
        campo.select2('val', '');
    }

    function carregaAssunto(codClassificacao) {
        var selected = assunto.val();
        clearSelect(assunto, true);
        assunto.attr('disabled', true);
        $.ajax({
            url: "/tributario/cadastro-imobiliario/lote/consultar-assunto",
            method: "POST",
            data: {codClassificacao: codClassificacao},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == index) {
                        assunto.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        assunto.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                assunto.select2('val', selected);
                assunto.attr('disabled', false);
            }
        });
    }

}());