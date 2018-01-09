(function () {
    'use strict';

    var codEvento = UrbemSonata.giveMeBackMyField('fkFolhapagamentoEvento'),
        exercicio = UrbemSonata.giveMeBackMyField('exercicio'),
        codSubDivisao = UrbemSonata.giveMeBackMyField('codSubDivisao'),
        codEspecialidade = UrbemSonata.giveMeBackMyField('codEspecialidade'),
        valor = UrbemSonata.giveMeBackMyField('valor'),
        quantidade = UrbemSonata.giveMeBackMyField('quantidade'),
        parcela = UrbemSonata.giveMeBackMyField('parcela'),
        caracteristica = UrbemSonata.giveMeBackMyField('fkFolhapagamentoConfiguracaoEvento'),
        limiteCalculo = UrbemSonata.giveMeBackMyField('limiteCalculo'),
        textoComplementar = UrbemSonata.giveMeBackMyField('textoComplementar');

    codEvento.on('change', function () {
        $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
        verificaConfiguracaoContratoManutencao();
    });

    if (codEvento.val() != '') {
        codEvento.attr('disabled', true);
        if (valor.attr('readonly') == 'readonly') {
            valor.parent().parent().hide();
        }
        if (parcela.attr('readonly') == 'readonly') {
            parcela.parent().parent().hide();
            limiteCalculo.parent().parent().hide();
        }
    } else {
        configuracaoPadrao();
    }

    function configuracaoPadrao() {
        valor.parent().parent().hide();
        valor.val('0,00');
        valor.attr('readonly', true);

        quantidade.parent().parent().hide();
        quantidade.val('0,00');
        quantidade.attr('required', false);
        quantidade.parent().parent().find('.control-label').removeClass('required');

        parcela.parent().parent().hide();
        parcela.val('');
        parcela.attr('readonly', true);

        limiteCalculo.parent().parent().hide();
        limiteCalculo.val('');

        caracteristica.select2('val', '');
        textoComplementar.val('');
    }

    function verificaConfiguracaoContratoManutencao() {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando...</h4>');
        $.ajax({
            url: "/recursos-humanos/folha-pagamento/evento/carrega-configuracao-contrato-manutencao",
            method: "POST",
            dataType: "json",
            data: {
                codEvento: codEvento.val(),
                codSubDivisao: codSubDivisao.val(),
                codEspecialidade: codEspecialidade.val()
            },
            success: function (data) {
                if (data.length > 0) {
                    carregaTextoComplementar();
                } else {
                    fechaModal();
                    codEvento.select2('val', '');
                    UrbemSonata.setFieldErrorMessage('codEvento', 'O evento informado não possui configuração para a subdivisão/cargo e/ou especialidade do contrato em manutenção.', codEvento.parent())
                }
            }
        })
    }

    function carregaTextoComplementar() {
        $.ajax({
            url: "/recursos-humanos/folha-pagamento/evento/carrega-texto-complementar",
            method: "POST",
            dataType: "json",
            data: {
                codEvento: codEvento.val()
            },
            success: function (data) {
                configuracaoPadrao();

                textoComplementar.val(data.observacao);
                caracteristica.select2('val', $('#' + UrbemSonata.uniqId +'_fkFolhapagamentoConfiguracaoEvento option:first-child').next().val());

                if (data.fixado == "Q") {
                    quantidade.attr('required', true);
                    quantidade.parent().parent().find('.control-label').addClass('required ');
                    quantidade.val(UrbemSonata.convertFloatToMoney(data.valorQuantidade));
                } else if (data.fixado == "V") {
                    valor.attr('required', true);
                    valor.attr('readonly', false);
                    valor.parent().parent().show();
                } else if (data.fixado == "1") {
                    quantidade.attr('required', false);
                    quantidade.parent().parent().find('.control-label').removeClass('required');
                }

                if (data.apresentaParcela) {
                    parcela.attr('readonly', false);
                    parcela.parent().parent().show();
                }

                if (data.limiteCalculo) {
                    limiteCalculo.parent().parent().show();
                }

                quantidade.parent().parent().show();

                fechaModal();
            }
        });
    }

    if (parcela.val() != "") {
        calculoLimite(parcela.val());
    }

    parcela.on('change', function () {
        calculoLimite($(this).val());
    });

    function calculoLimite(parcela) {
        if (parcela != 0) {
            var date = new Date('Jan 01 ' + exercicio.val());
            date.setMonth(date.getMonth() + (parseInt(parcela) - 1));

            var mes =  '' + (date.getMonth() + 1),
                pad = '00';
            limiteCalculo.val((pad.substring(0, pad.length - mes.length) + mes) + '/' + date.getFullYear());
        }
    }

    valor.on('change', function () {
        $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    quantidade.on('change', function () {
        $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    parcela.on('change', function () {
        $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    $('.save').on('click', function () {
        var erro = false;

        if ((valor.attr('required') == 'required') && (valor.attr('readonly') != 'readonly') && (UrbemSonata.convertMoneyToFloat(valor.val()) == 0)) {
            UrbemSonata.setFieldErrorMessage('valor', 'Valor não pode ser igual a 0,00.', valor.parent());
            erro = true;
        }

        if ((quantidade.attr('required') == 'required') && (quantidade.attr('readonly') != 'readonly') && (UrbemSonata.convertMoneyToFloat(quantidade.val()) == 0)) {
            UrbemSonata.setFieldErrorMessage('quantidade', 'Quantidade não pode ser igual a 0,00.', quantidade.parent());
            erro = true;
        }

        if ((parcela.attr('required') == 'required') && (parcela.attr('readonly') != 'readonly') && (parseInt(parcela.val()) == 0)) {
            UrbemSonata.setFieldErrorMessage('parcela', 'Quantidade de Parcelas não pode ser igual a 0.', parcela.parent());
            erro = true;
        }

        if (erro) {
            return false;
        }

        return true;
    });
}());
