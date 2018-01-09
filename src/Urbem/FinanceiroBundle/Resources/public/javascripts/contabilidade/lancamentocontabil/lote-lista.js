$(document).ready(function() {
    'use strict';

    if ($('#lote_incluirAssinaturas_1').val() != undefined) {
        return false;
    }

    var debito_sequencia = $('#' + UrbemSonata.uniqId + '_debito__sequencia'),
        debito_conta = $('#' + UrbemSonata.uniqId + '_debito__fkContabilidadePlanoAnalitica_autocomplete_input'),
        debito_vlLancamento = $('#' + UrbemSonata.uniqId + '_debito__vlLancamento'),
        debito_historico = $('#' + UrbemSonata.uniqId + '_debito__fkContabilidadeHistoricoContabil_autocomplete_input'),
        debito_complemento = $('#' + UrbemSonata.uniqId + '_debito__complemento'),
        debito_model = $('.row-model-debito'),
        vlDebito = $('#' + UrbemSonata.uniqId + '_totais__vlDebito'),
        vlCredito= $('#' + UrbemSonata.uniqId + '_totais__vlCredito'),
        vlDiferenca = $('#' + UrbemSonata.uniqId + '_totais__vlDiferenca'),
        idSequencia = 1,
        credito_sequencia = $('#' + UrbemSonata.uniqId + '_credito__sequencia'),
        credito_conta = $('#' + UrbemSonata.uniqId + '_credito__fkContabilidadePlanoAnalitica_autocomplete_input'),
        credito_vlLancamento = $('#' + UrbemSonata.uniqId + '_credito__vlLancamento'),
        credito_historico = $('#' + UrbemSonata.uniqId + '_credito__fkContabilidadeHistoricoContabil_autocomplete_input'),
        credito_complemento = $('#' + UrbemSonata.uniqId + '_credito__complemento'),
        credito_model = $('.row-model-credito'),
        icSequencia = 1,
        exercicio = $('#' + UrbemSonata.uniqId + '_exercicio'),
        dataLote = $('#' + UrbemSonata.uniqId + '_dtLote');

    $('.row-model-debito').remove();
    $('.row-model-credito').remove();

    debito_conta.attr('required', false);
    debito_vlLancamento.attr('required', false);
    debito_historico.attr('required', false);

    credito_conta.attr('required', false);
    credito_vlLancamento.attr('required', false);
    credito_historico.attr('required', false);

    // Débitos
    $("#edit_debito").parent().hide();
    $("#cancel_debito").attr('value', 'Limpar');
    $("#cancel_debito").on("click", function() {
        debito_sequencia.val('');
        debito_conta.select2('val', '');
        debito_historico.select2('val', '');
        debito_vlLancamento.val('');
        debito_complemento.val('');
        $("#edit_debito").parent().hide();
        $("#create_debito").parent().show();
        $("#cancel_debito").attr('value', 'Limpar');
    });

    debito_conta.on ('change', function () {
        $('.sonata-ba-field-error-messages').remove();
       $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
    });

    $("#create_debito").on("click", function() {
        if ((debito_conta.val() == '') || (debito_vlLancamento.val() <= 0) || (debito_historico.val() == '')) {
            UrbemSonata.setFieldErrorMessage('debitoConta', 'Preencha todos os campos obrigatórios.', debito_conta.parent());
            return false;
        }

        // Verificar se conta está em uso
        var usoEmDebito = false;
        $('.imput-debito-cod-plano').each(function(){
            if ($(this).val() == debito_conta.val()) {
                usoEmDebito = true;
                return false;
            }
        });
        if (usoEmDebito) {
            UrbemSonata.setFieldErrorMessage('debitoConta', 'Conta já está sendo utilizada na lista.', debito_conta.parent());
            return false;
        }

        var usoEmCredito = false;
        $('.imput-credito-cod-plano').each(function(){
            if ($(this).val() == debito_conta.val()) {
                usoEmCredito = true;
                return false;
            }
        });
        if (usoEmCredito) {
            UrbemSonata.setFieldErrorMessage('debitoConta', 'Conta já está sendo utilizada à Crédito.', debito_conta.parent());
            return false;
        }

        lancamentoDebito(true);
    });

    $("#edit_debito").on("click", function() {
        if ((debito_conta.val() == '') || (debito_vlLancamento.val() <= 0) || (debito_historico.val() == '')) {
            UrbemSonata.setFieldErrorMessage('debitoConta', 'Preencha todos os campos obrigatórios.', debito_conta.parent());
            return false;
        }

        // Verificar se conta está em uso
        var usoEmDebito = false;
        $('.imput-debito-cod-plano').each(function(){
            if (($(this).val() == debito_conta.val()) && ($(this).parent().find('.imput-debito-id').attr('value') != debito_sequencia.val())) {
                usoEmDebito = true;
                return false;
            }
        });
        if (usoEmDebito) {
            UrbemSonata.setFieldErrorMessage('debitoConta', 'Conta já está sendo utilizada na lista.', debito_conta.parent());
            return false;
        }

        var usoEmCredito = false;
        $('.imput-credito-cod-plano').each(function(){
            if ($(this).val() == debito_conta.val()) {
                usoEmCredito = true;
                return false;
            }
        });
        if (usoEmCredito) {
            UrbemSonata.setFieldErrorMessage('debitoConta', 'Conta já está sendo utilizada à Crédito.', debito_conta.parent());
            return false;
        }

        lancamentoDebito(false);
    });

    function lancamentoDebito(create) {
        if (create) {
            var row = debito_model.clone();
            row.removeClass('row-model-debito');
            row.addClass('row-debito');
            row.attr('id', 'debito-' + idSequencia);
            row.find('.conta').html(debito_conta.select2('data').label);
            row.find('.historico').html(debito_historico.select2('data').label);
            row.find('.valor').html('R$' + UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(debito_vlLancamento.val())));
            row.find('.imput-debito-id').attr('value', idSequencia);
            row.find('.imput-debito-cod-plano').attr('value', debito_conta.val());
            row.find('.imput-debito-nom-conta').attr('value', debito_conta.select2('data').label);
            row.find('.imput-debito-cod-historico').attr('value', debito_historico.val());
            row.find('.imput-debito-nom-historico').attr('value', debito_historico.select2('data').label);
            row.find('.imput-debito-vl-lancamento').attr('value', UrbemSonata.convertMoneyToFloat(debito_vlLancamento.val()));
            row.find('.imput-debito-complemento').attr('value', debito_complemento.val());
            row.show();

            vlDebito.val(UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(vlDebito.val()) + UrbemSonata.convertMoneyToFloat(debito_vlLancamento.val())));

            $('.empty-row-debito').hide();
            $('#tableManual_debito').append(row);

            debito_sequencia.val('');
            debito_conta.select2('val', '');
            debito_historico.select2('val', '');
            debito_vlLancamento.val('');
            debito_complemento.val('');

            idSequencia = idSequencia + 1;
        } else {
            var row = $('#debito-' + debito_sequencia.val());

            vlDebito.val(UrbemSonata.convertFloatToMoney((UrbemSonata.convertMoneyToFloat(vlDebito.val()) - row.find('.imput-debito-vl-lancamento').attr('value')) + UrbemSonata.convertMoneyToFloat(debito_vlLancamento.val())));

            row.find('.conta').html(debito_conta.select2('data').label);
            row.find('.historico').html(debito_historico.select2('data').label);
            row.find('.valor').html('R$' + UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(debito_vlLancamento.val())));
            row.find('.imput-debito-cod-plano').attr('value', debito_conta.val());
            row.find('.imput-debito-nom-conta').attr('value', debito_conta.select2('data').label);
            row.find('.imput-debito-cod-historico').attr('value', debito_historico.val());
            row.find('.imput-debito-nom-historico').attr('value', debito_historico.select2('data').label);
            row.find('.imput-debito-vl-lancamento').attr('value', UrbemSonata.convertMoneyToFloat(debito_vlLancamento.val()));
            row.find('.imput-debito-complemento').attr('value', debito_complemento.val());

            debito_sequencia.val('');
            debito_conta.select2('val', '');
            debito_historico.select2('val', '');
            debito_vlLancamento.val('');
            debito_complemento.val('');

            $("#edit_debito").parent().hide();
            $("#create_debito").parent().show();
            $("#cancel_debito").attr('value', 'Limpar');
        }
        calculaDiferenca();
    }

    $(document).on('click', '.remove-debito', function () {
        var row = $(this).parent().parent();
        vlDebito.val(UrbemSonata.convertFloatToMoney((UrbemSonata.convertMoneyToFloat(vlDebito.val()) - row.find('.imput-debito-vl-lancamento').attr('value'))));
        $(this).parent().parent().remove();
        if ($('.row-debito').length <= 0) {
            $('.empty-row-debito').show();
        }
        calculaDiferenca();
    });

    $(document).on('click', '.edit-debito', function () {
        var row = $(this).parent().parent();

        debito_sequencia.val(row.find('.imput-debito-id').attr('value'));
        debito_conta.select2('data', {id: row.find('.imput-debito-cod-plano').attr('value'), label: row.find('.imput-debito-nom-conta').attr('value')});
        debito_historico.select2('data', {id: row.find('.imput-debito-cod-historico').attr('value'), label: row.find('.imput-debito-nom-historico').attr('value')});
        debito_vlLancamento.val(UrbemSonata.convertFloatToMoney(row.find('.imput-debito-vl-lancamento').attr('value')));
        debito_complemento.val(row.find('.imput-debito-complemento').attr('value'));

        $("#create_debito").parent().hide();
        $("#edit_debito").parent().show();
        $("#cancel_debito").attr('value', 'Cancelar');
    });

    // Créditos
    $("#edit_credito").parent().hide();
    $("#cancel_credito").attr('value', 'Limpar');
    $("#cancel_credito").on("click", function() {
        credito_sequencia.val('');
        credito_conta.select2('val', '');
        credito_historico.select2('val', '');
        credito_vlLancamento.val('');
        credito_complemento.val('');
        $("#edit_credito").parent().hide();
        $("#create_credito").parent().show();
        $("#cancel_credito").attr('value', 'Limpar');
    });

    credito_conta.on('change', function () {
        $('.sonata-ba-field-error-messages').remove();
        $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
    });

    $("#create_credito").on("click", function() {
        if ((credito_conta.val() == '') || (credito_vlLancamento.val() <= 0) || (credito_historico.val() == '')) {
            UrbemSonata.setFieldErrorMessage('creditoConta', 'Preencha todos os campos obrigatórios.', credito_conta.parent());
            return false;
        }

        // Verificar se conta está em uso
        var usoEmCredito = false;
        $('.imput-credito-cod-plano').each(function(){
            if ($(this).val() == credito_conta.val()) {
                usoEmCredito = true;
                return false;
            }
        });
        if (usoEmCredito) {
            UrbemSonata.setFieldErrorMessage('creditoConta', 'Conta já está sendo utilizada na lista.', credito_conta.parent());
            return false;
        }

        var usoEmDebito = false;
        $('.imput-debito-cod-plano').each(function(){
            if ($(this).val() == credito_conta.val()) {
                usoEmDebito = true;
                return false;
            }
        });
        if (usoEmDebito) {
            UrbemSonata.setFieldErrorMessage('creditoConta', 'Conta já está sendo utilizada à Débito.', credito_conta.parent());
            return false;
        }

        lancamentoCredito(true);
    });

    $("#edit_credito").on("click", function() {
        if ((credito_conta.val() == '') || (credito_vlLancamento.val() <= 0) || (credito_historico.val() == '')) {
            UrbemSonata.setFieldErrorMessage('creditoConta', 'Preencha todos os campos obrigatórios.', credito_conta.parent());
            return false;
        }

        // Verificar se conta está em uso
        var usoEmCredito = false;
        $('.imput-credito-cod-plano').each(function(){
            if (($(this).val() == credito_conta.val()) && ($(this).parent().find('.imput-credito-id').attr('value') != credito_sequencia.val())) {
                usoEmCredito = true;
                return false;
            }
        });
        if (usoEmCredito) {
            UrbemSonata.setFieldErrorMessage('creditoConta', 'Conta já está sendo utilizada na lista.', credito_conta.parent());
            return false;
        }

        var usoEmDebito = false;
        $('.imput-debito-cod-plano').each(function(){
            if ($(this).val() == credito_conta.val()) {
                usoEmDebito = true;
                return false;
            }
        });
        if (usoEmDebito) {
            UrbemSonata.setFieldErrorMessage('creditoConta', 'Conta já está sendo utilizada à Débito.', credito_conta.parent());
            return false;
        }

        lancamentoCredito(false);
    });

    function lancamentoCredito(create) {
        if (create) {
            var row = credito_model.clone();
            row.removeClass('row-model-credito');
            row.addClass('row-credito');
            row.attr('id', 'credito-' + icSequencia);
            row.find('.conta').html(credito_conta.select2('data').label);
            row.find('.historico').html(credito_historico.select2('data').label);
            row.find('.valor').html('R$' + UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(credito_vlLancamento.val())));
            row.find('.imput-credito-id').attr('value', icSequencia);
            row.find('.imput-credito-cod-plano').attr('value', credito_conta.val());
            row.find('.imput-credito-nom-conta').attr('value', credito_conta.select2('data').label);
            row.find('.imput-credito-cod-historico').attr('value', credito_historico.val());
            row.find('.imput-credito-nom-historico').attr('value', credito_historico.select2('data').label);
            row.find('.imput-credito-vl-lancamento').attr('value', UrbemSonata.convertMoneyToFloat(credito_vlLancamento.val()));
            row.find('.imput-credito-complemento').attr('value', credito_complemento.val());
            row.show();

            vlCredito.val(UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(vlCredito.val()) + UrbemSonata.convertMoneyToFloat(credito_vlLancamento.val())));

            $('.empty-row-credito').hide();
            $('#tableManual_credito').append(row);

            credito_sequencia.val('');
            credito_conta.select2('val', '');
            credito_historico.select2('val', '');
            credito_vlLancamento.val('');
            credito_complemento.val('');

            icSequencia = icSequencia + 1;
        } else {
            var row = $('#credito-' + credito_sequencia.val());

            vlCredito.val(UrbemSonata.convertFloatToMoney((UrbemSonata.convertMoneyToFloat(vlCredito.val()) - row.find('.imput-credito-vl-lancamento').attr('value')) + UrbemSonata.convertMoneyToFloat(credito_vlLancamento.val())));

            row.find('.conta').html(credito_conta.select2('data').label);
            row.find('.historico').html(credito_historico.select2('data').label);
            row.find('.valor').html('R$' + UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(credito_vlLancamento.val())));
            row.find('.imput-credito-cod-plano').attr('value', credito_conta.val());
            row.find('.imput-credito-nom-conta').attr('value', credito_conta.select2('data').label);
            row.find('.imput-credito-cod-historico').attr('value', credito_historico.val());
            row.find('.imput-credito-nom-historico').attr('value', credito_historico.select2('data').label);
            row.find('.imput-credito-vl-lancamento').attr('value', UrbemSonata.convertMoneyToFloat(credito_vlLancamento.val()));
            row.find('.imput-credito-complemento').attr('value', credito_complemento.val());

            credito_sequencia.val('');
            credito_conta.select2('val', '');
            credito_historico.select2('val', '');
            credito_vlLancamento.val('');
            credito_complemento.val('');

            $("#edit_credito").parent().hide();
            $("#create_credito").parent().show();
            $("#cancel_credito").attr('value', 'Limpar');
        }
        calculaDiferenca();
    }

    $(document).on('click', '.remove-credito', function () {
        var row = $(this).parent().parent();
        vlCredito.val(UrbemSonata.convertFloatToMoney((UrbemSonata.convertMoneyToFloat(vlCredito.val()) - row.find('.imput-credito-vl-lancamento').attr('value'))));
        $(this).parent().parent().remove();
        if ($('.row-credito').length <= 0) {
            $('.empty-row-credito').show();
        }
        calculaDiferenca();
    });

    $(document).on('click', '.edit-credito', function () {
        var row = $(this).parent().parent();

        credito_sequencia.val(row.find('.imput-credito-id').attr('value'));
        credito_conta.select2('data', {id: row.find('.imput-credito-cod-plano').attr('value'), label: row.find('.imput-credito-nom-conta').attr('value')});
        credito_historico.select2('data', {id: row.find('.imput-credito-cod-historico').attr('value'), label: row.find('.imput-credito-nom-historico').attr('value')});
        credito_vlLancamento.val(UrbemSonata.convertFloatToMoney(row.find('.imput-credito-vl-lancamento').attr('value')));
        credito_complemento.val(row.find('.imput-credito-complemento').attr('value'));

        $("#create_credito").parent().hide();
        $("#edit_credito").parent().show();
        $("#cancel_credito").attr('value', 'Cancelar');
    });

    function calculaDiferenca() {
        $('.sonata-ba-field-error-messages').remove();
        vlDiferenca.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        vlDiferenca.val(UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(vlCredito.val()) - UrbemSonata.convertMoneyToFloat(vlDebito.val())));
    }

    if ($('.row-debito').length > 0) {
        $('.empty-row-debito').hide();
    }

    if ($('.row-credito').length > 0) {
        $('.empty-row-credito').hide();
    }

    $('.save').on('click', function () {
        if ((UrbemSonata.convertMoneyToFloat(vlDebito.val()) === 0) && (UrbemSonata.convertMoneyToFloat(vlCredito.val()) === 0)) {
            UrbemSonata.setFieldErrorMessage('contaDebito', 'Informe os lançamentos para inclusão.', debito_conta.parent());
            UrbemSonata.setFieldErrorMessage('contaCredito', 'Informe os lançamentos para inclusão.', credito_conta.parent());
            return false;
        } else if (UrbemSonata.convertMoneyToFloat(vlDiferenca.val()) !== 0) {
            UrbemSonata.setFieldErrorMessage('vlDiferenca', 'Existe diferença de débito e crédito.', vlDiferenca.parent().parent());
            return false;
        }
    });

    dataLote.on('change', function () {
        if ($(this).val() != '') {
            $('.sonata-ba-field-error-messages').remove();
            $(this).parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
            verificaMesProcessamento($(this).val(), exercicio.val());
        }
    });

    function verificaMesProcessamento(dtLote, exercicio) {
        $.ajax({
            url: "/financeiro/contabilidade/lancamento-contabil/verifica-mes-processamento",
            method: "POST",
            data: { dtLote: dtLote, exercicio: exercicio },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    dataLote.val('');
                    UrbemSonata.setFieldErrorMessage('dtLote', 'Data do lote fora do mês de processamento.', dataLote.parent().parent());
                } else {
                    verificaAnoProcessamento(dtLote, exercicio);
                }
            }
        });
    }

    function verificaAnoProcessamento(dtLote, exercicio) {
        $.ajax({
            url: "/financeiro/contabilidade/lancamento-contabil/verifica-ano-processamento",
            method: "POST",
            data: { dtLote: dtLote, exercicio: exercicio },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    dataLote.val('');
                    UrbemSonata.setFieldErrorMessage('dtLote', 'Data do lote fora do exercício atual.', dataLote.parent().parent());
                }
            }
        });
    }
}());