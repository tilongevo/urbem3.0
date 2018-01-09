(function ($, global, urbem) {
    'use strict';

    var modal,
        UrbemSearch = urbem.UrbemSearch,
        codBancoSalario = urbem.giveMeBackMyField('codBancoSalario'),
        codAgenciaSalario = urbem.giveMeBackMyField('codAgenciaSalario'),
        codBancoFgts = urbem.giveMeBackMyField('codBancoFgts'),
        codAgenciaFgts = urbem.giveMeBackMyField('codAgenciaFgts'),
        nrContaSalario = urbem.giveMeBackMyField('nrContaSalario'),
        codFormaPagamento = urbem.giveMeBackMyField('codFormaPagamento')
    ;

    $(document).ready(function() {
        if (codFormaPagamento.val() != 3) {
            codBancoSalario.select2('disable');
            codAgenciaSalario.select2('disable');
            nrContaSalario.prop('disabled', true);
        }
    });

    codFormaPagamento.on('change', function () {
        if ($(this).val() == 3) {
            codBancoSalario.select2('enable');
            codAgenciaSalario.select2('enable');
            nrContaSalario.prop('disabled', false);
        } else {
            codBancoSalario.select2('disable');
            codAgenciaSalario.select2('disable');
            nrContaSalario.prop('disabled', true);
            codBancoSalario.val('').trigger('change');
            codAgenciaSalario.val('').trigger('change');
            nrContaSalario.val('');
        }
    });

    if (urbem.isFunction($.urbemModal)) {
        modal = $.urbemModal();
    }

    codBancoSalario.on('change', function () {
        if ($(this).val() != "") {
            modal.disableBackdrop()
                .setTitle('Aguarde...')
                .setBody('Buscando agências (Salário)...')
                .open();

            UrbemSearch.findAgenciasByBanco($(this).val())
            .success(function (data) {
                urbem.populateSelect(codAgenciaSalario, data, {value: 'codAgencia', label: 'nomAgencia'});
                modal.close();
            });
        }
    });

    codBancoFgts.on('change', function () {
        if ($(this).val() != "") {
            modal.disableBackdrop()
                .setTitle('Aguarde...')
                .setBody('Buscando agências (Fgts)...')
                .open();

            UrbemSearch.findAgenciasByBanco($(this).val())
                .success(function (data) {
                    urbem.populateSelect(codAgenciaFgts, data, {value: 'codAgencia', label: 'nomAgencia'});
                    modal.close();
                });
        }
    });

})(jQuery, window, UrbemSonata);
