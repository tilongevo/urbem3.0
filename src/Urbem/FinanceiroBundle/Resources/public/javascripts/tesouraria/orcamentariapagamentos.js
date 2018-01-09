var exercicio = UrbemSonata.giveMeBackMyField('exercicio'),
    conta = UrbemSonata.giveMeBackMyField('contaPagadora'),
    registros = $('.vl-pagamento'),
    numero = UrbemSonata.giveMeBackMyField('numero'),
    numeroContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_numero'),
    tipoDocumento = UrbemSonata.giveMeBackMyField('tipoDocumento');

if (conta != undefined) {
    conta.on('change', function () {
        var vlPagamento = 0.00;
        registros.each(function () {
            vlPagamento += UrbemSonata.convertMoneyToFloat($(this).val());
        });
        consultaSaldoConta($(this).val(), exercicio.val(), vlPagamento);
    });

    function consultaSaldoConta(exercicio, codPlano, vlPagamento) {
        $.ajax({
            url: "/financeiro/tesouraria/pagamentos/orcamentaria-pagamentos/saldo-conta",
            method: "POST",
            data: {id: codPlano + '~' + exercicio},
            dataType: "json",
            success: function (data) {
                if ((data - vlPagamento) < 0) {
                    $('.sonata-ba-field-error-messages').remove();
                    var message = '<div class="help-block sonata-ba-field-error-messages">' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-exclamation-circle"></i> O saldo da conta informada é inferior a do pagamento! Se continuar o saldo da conta ficará negativo.</li>' +
                        '</ul>' +
                        '</div>';
                    conta.after(message);
                }
            }
        });
    }
}

if (tipoDocumento != undefined) {
    numeroContainer.hide();
    numero.attr('required', false);

    tipoDocumento.on('change', function () {
        var mostrar = mostraNumero($(this).val());
        if (!mostrar) {
            numeroContainer.show();
            numero.attr('required', true);
        } else {
            numeroContainer.hide();
            numero.attr('required', false);
        }
    });

    function mostraNumero(tipo) {
        switch(parseInt(tipo)) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 99:
            default:
                return false;
                break;
            case 5:
                return true;
                break;
        }
    }
}