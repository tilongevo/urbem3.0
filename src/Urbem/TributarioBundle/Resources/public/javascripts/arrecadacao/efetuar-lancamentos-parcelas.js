$(function () {
    "use strict";

    var cotasUnicas = $('#' + UrbemSonata.uniqId + '_tipoParcela_0'),
        desconto = $('#' + UrbemSonata.uniqId + '_desconto'),
        formaDescontoPercentual = $('#' + UrbemSonata.uniqId + '_formaDesconto_0'),
        dtPrimeiroVencimento = $('#' +  UrbemSonata.uniqId + '_dtPrimeiroVencimento'),
        quantidadeParcelas = $('#' +  UrbemSonata.uniqId + '_quantidadeParcelas'),
        modeloParcela = $('.row-modelo-parcela'),
        nroParcelas = 0;

    $('.row-modelo-parcela').remove();

    dtPrimeiroVencimento.attr('required', false);
    quantidadeParcelas.attr('required', false);

    function convertTextToDate(text) {
        var exp = text.split("/");
        return new Date(parseInt(exp[2]), (parseInt(exp[1])-1), parseInt(exp[0]));
    }
    
    function verifyWeekend(date) {
        if (date.getDay() == 0) {
            return date.getDate() + 1;
        } else if (date.getDay() == 6) {
            return date.getDate() + 2;
        } else {
            return date.getDate();
        }
    }

    // 0 - Domingo
    // 6 - Sabado
    function convertDateToText(date) {
        var pad = '00';
        return (pad + verifyWeekend(date)).slice(-pad.length) + '/' + (pad + (date.getMonth() + 1)).slice(-pad.length) + '/' + date.getFullYear();
    }

    $("#manuais").on("click", function() {
        if (nroParcelas == 12) {

        }
        novaLinha();
        nroParcelas += 1;
    });

    function novaLinha() {
        $('.sonata-ba-field-error-messages').remove();
        $('.empty-row-parcelas').hide();

        for (var i = 1; i <= parseInt(quantidadeParcelas.val()); i++) {
            var row = modeloParcela.clone();
            row.removeClass('row-modelo-parcela');
            row.addClass('row-parcela');
            row.attr('id', 'parcela-' + i);

            if (cotasUnicas.is(":checked")) {
                row.find('.tipo-parcela-normal').hide();
                row.find('.imput-tipo-parcela').attr('value', 0);
            } else {
                row.find('.tipo-parcela-unica').hide();
                row.find('.imput-tipo-parcela').attr('value', 1);
            }

            row.find('.date').attr('id', 'dp-vencimento-' + i);
            var date = convertTextToDate(dtPrimeiroVencimento.val());
            date.setMonth(date.getMonth() + (i -1));
            row.find('.imput-vencimento').attr('value', convertDateToText(date));
            row.find('.date').datetimepicker({"pickTime":false,"useCurrent":true,"minDate":"1\/1\/1900","maxDate":null,"showToday":true,"language":"pt_BR","defaultDate":"","disabledDates":[],"enabledDates":[],"icons":{"time":"fa fa-clock-o","date":"fa fa-calendar","up":"fa fa-chevron-up","down":"fa fa-chevron-down"},"useStrict":false,"sideBySide":false,"daysOfWeekDisabled":[],"collapse":true,"calendarWeeks":false,"viewMode":"days","useSeconds":false});

            row.find('.imput-desconto').attr('value', desconto.val());
            row.find('.desconto').html(desconto.val());

            if (formaDescontoPercentual.is(":checked")) {
                row.find('.forma-desconto-absoluto').hide();
                row.find('.imput-forma-desconto').attr('value', 0);
            } else {
                row.find('.forma-desconto-percentual').hide();
                row.find('.imput-forma-desconto').attr('value', 1);
            }
            row.show();

            $('#tableParcelasManuais').append(row);
        }

        cotasUnicas.iCheck('check');
        formaDescontoPercentual.iCheck('check');
        desconto.val('0,00');
        dtPrimeiroVencimento.val('');
        quantidadeParcelas.val(1);
    }

    $('form').submit(function() {
        if (nroParcelas <= 0) {
            UrbemSonata.setFieldErrorMessage('quantidadeParcelas', 'É necessário incluir pelo menos uma Parcela para este lançamento.', quantidadeParcelas.parent());
            $('html, body').animate({
                scrollTop: quantidadeParcelas.offset().top
            }, 500);
            return false;
        }
        return true;
    });

    quantidadeParcelas.on('mouseover', function () {
        quantidadeParcelas.parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        nroParcelas -= 1;
        if ($(".row-parcela").length <= 0) {
            $('.empty-row-parcelas').show();
        }
    });
}());