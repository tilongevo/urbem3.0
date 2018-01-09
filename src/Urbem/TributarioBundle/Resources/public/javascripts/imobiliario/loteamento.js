$(function () {
    "use strict";

    var codLoteamento = UrbemSonata.giveMeBackMyField('codLoteamento'),
        localizacao = $("#" + UrbemSonata.uniqId + "_localizacao_autocomplete_input"),
        lote = $("#" + UrbemSonata.uniqId + "_lote_autocomplete_input"),
        loteLoteamento_localizacao = $("#" + UrbemSonata.uniqId + "_loteLoteamento_localizacao_autocomplete_input"),
        loteLoteamento_lote = $("#" + UrbemSonata.uniqId + "_loteLoteamento_lote_autocomplete_input"),
        loteLoteamento_caucionado = UrbemSonata.giveMeBackMyField('loteLoteamento_caucionado'),
        modeloLote = $('.row-modelo-lotes');

    loteLoteamento_localizacao.attr('required', false);
    loteLoteamento_lote.attr('required', false);

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        window.varJsCodLocalizacao = $(this).val();
    });

    window.varJsLoteLoteamentoCodLocalizacao = loteLoteamento_localizacao.val();
    loteLoteamento_localizacao.on("change", function() {
        window.varJsLoteLoteamentoCodLocalizacao = $(this).val();
    });

    window.varJsCodLote = lote.val();
    lote.on("change", function() {
        window.varJsCodLote = $(this).val();
    });

    if (loteLoteamento_caucionado == undefined) {
        return false;
    }

    if (localizacao.val() == '') {
        lote.select2('disable');
        loteLoteamento_localizacao.select2('disable');
        loteLoteamento_lote.select2('disable');
        loteLoteamento_caucionado.attr('disabled', true);
    }

    localizacao.on('change', function () {
        if ($(this).val() != '') {
            lote.select2('enable');
        } else {
            lote.select2('val', '');
            lote.select2('disable');
            loteLoteamento_localizacao.select2('val', '');
            loteLoteamento_localizacao.select2('disable');
            loteLoteamento_lote.select2('val', '');
            loteLoteamento_lote.select2('disable');
        }
    });

    lote.on('change', function () {
        if ($(this).val() != '') {
            loteLoteamento_localizacao.select2('enable');
        } else {
            loteLoteamento_localizacao.select2('val', '');
            loteLoteamento_localizacao.select2('disable');
            loteLoteamento_lote.select2('val', '');
            loteLoteamento_lote.select2('disable');
        }
    });

    loteLoteamento_localizacao.on('change', function () {
        if ($(this).val() != '') {
            loteLoteamento_lote.select2('enable');
            loteLoteamento_caucionado.attr('disabled', false);
        } else {
            loteLoteamento_lote.select2('val', '');
            loteLoteamento_lote.select2('disable');
        }
    });


    $("#manuais").on("click", function() {
        if ($('#lote-' + loteLoteamento_lote.val()).length >= 1) {
            mensagemErro(loteLoteamento_lote, 'Lote já informado!');
            return false;
        }
        verificaLote(loteLoteamento_lote.val(), codLoteamento.val())
    });

    function novaLinha()
    {
        if (loteLoteamento_lote.val() == '') {
            return false;
        }

        localizacao.select2('disable');
        lote.select2('disable');

        $('.sonata-ba-field-error-messages').remove();

        var row = modeloLote.clone();
        row.removeClass('row-modelo-lotes');
        row.addClass('row-lotes');
        row.attr('id', 'lote-' + loteLoteamento_lote.val());
        row.find('.lote').append(loteLoteamento_lote.select2('data').label);
        row.find('.localizacao').html(loteLoteamento_localizacao.select2('data').label);
        row.find('.caucionado').html((loteLoteamento_caucionado.val() == 1) ? 'Sim' : 'Não');
        row.find('.imput-lotes').attr('value', loteLoteamento_lote.val());
        row.find('.imput-lotes-caucionados').attr('value', loteLoteamento_caucionado.val());
        row.show();

        $('.empty-row-lotes').hide();
        $('#tableLoteLoteamentosManuais').append(row);

        loteLoteamento_lote.select2('val', '');
    }

    loteLoteamento_lote.on('click', function () {
        $('.sonata-ba-field-error-messages').remove();
    });

    if ($(".row-lotes").length > 0) {
        $('.empty-row-lotes').hide();
    }

    $('form').submit(function() {
        localizacao.select2('enable');
        lote.select2('enable');
        if ($(".row-lotes").length <= 0) {
            mensagemErro(loteLoteamento_lote, 'Deve ser informado ao menos um Lote!');
            return false;
        }
        return true;
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".row-lotes").length <= 0) {
            localizacao.select2('enable');
            lote.select2('enable');
            $('.empty-row-lotes').show();
        }
    });

    function mensagemErro(campo, memsagem) {
        var message = '<div class="help-block sonata-ba-field-error-messages">' +
            '<ul class="list-unstyled">' +
            '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
            '</ul></div>';
        campo.after(message);
    }

    function verificaLote(codLote, codLoteamento) {
        if (codLote != '') {
            $.ajax({
                url: "/tributario/cadastro-imobiliario/loteamento/lote-disponivel",
                method: "POST",
                data: {codLote: codLote, codLoteamento: codLoteamento},
                dataType: "json",
                success: function (data) {
                    if (data) {
                        novaLinha();
                    } else {
                        mensagemErro(loteLoteamento_lote, 'Lote existente em outro Loteamento!');
                    }
                }
            });
        }
    }
}());