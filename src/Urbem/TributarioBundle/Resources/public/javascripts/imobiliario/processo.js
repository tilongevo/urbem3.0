$(function () {
    "use strict";

    var classificacao = UrbemSonata.giveMeBackMyField('fkSwClassificacao'),
        assunto = UrbemSonata.giveMeBackMyField('fkSwAssunto'),
        processo = $("#" + UrbemSonata.uniqId + "_fkSwProcesso_autocomplete_input");

    if (classificacao == undefined) {
        return false;
    }

    window.varJsCodClassificacao = classificacao.val();
    classificacao.on("change", function() {
        if ($(this).val() != '') {
            carregaAssunto($(this).val(), '');
        } else {
            clearSelect(assunto, true);
            assunto.attr('disabled', true);
            processo.select2('val', '');
        }
        window.varJsCodClassificacao = $(this).val();
    });

    window.varJsCodAssunto = assunto.val();
    assunto.on("change", function() {
        window.varJsCodAssunto = $(this).val();
        processo.select2('val', '');
    });

    function clearSelect(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append('<option value="">Selecione</option>');
        }
        campo.select2('val', '');
    }

    if (classificacao.val() == '') {
        assunto.attr('disabled', true);
    } else {
        processo.select2('enable');
        carregaAssunto(classificacao.val(), '');
    }

    if (UrbemSonata.giveMeBackMyField('fkSwClassificacao').attr('disabled')) {
        processo.select2('disable')
    }

    function carregaAssunto(codClassificacao, codAssunto) {
        if (codAssunto != '') {
            var selected = codAssunto;
        } else {
            var selected = assunto.val();
        }
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
                if (!UrbemSonata.giveMeBackMyField('fkSwClassificacao').attr('disabled')) {
                    assunto.attr('disabled', false);
                }
            }
        });
    }

    processo.on('change', function () {
        if  ($(this).val()) {
            var processo = $(this).val();
            $.ajax({
                url: "/tributario/cadastro-imobiliario/lote/consultar-processo",
                method: "POST",
                data: {processo: processo},
                dataType: "json",
                success: function (data) {
                    classificacao.select2('val', data.codClassificacao);
                    assunto.select2('enable');
                    assunto.select2('val', data.codAssunto);
                    carregaAssunto(data.codClassificacao, data.codAssunto);
                }
            });
        }
    })
}());