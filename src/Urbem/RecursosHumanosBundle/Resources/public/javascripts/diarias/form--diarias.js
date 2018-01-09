var varJsCodTipoNorma,
    varJsCodUf
;

(function ($, global, urbem) {
    'use strict';

    var modal,
        codTipoNorma = urbem.giveMeBackMyField('codTipoNorma'),
        codPais = urbem.giveMeBackMyField('codPais'),
        codUf = urbem.giveMeBackMyField('codUf'),
        fkSwMunicipio = urbem.giveMeBackMyField('fkSwMunicipio'),
        fkDiariasTipoDiaria = urbem.giveMeBackMyField('fkDiariasTipoDiaria'),
        vlUnitario = urbem.giveMeBackMyField('vlUnitario'),
        quantidade = urbem.giveMeBackMyField('quantidade')
    ;

    function calculaQuantidadeDiarias( quantidade ) {
        var vlUnitario = urbem.giveMeBackMyField('vlUnitario'),
            vlTotal = urbem.giveMeBackMyField('vlTotal'),
            floatVlUnitario,
            intQuantidade,
            floatVlTotal
        ;

        floatVlUnitario = urbem.convertMoneyToFloat(vlUnitario.val());
        intQuantidade = parseInt(quantidade);

        floatVlTotal = floatVlUnitario * intQuantidade;

        if (isNaN(floatVlTotal)) {
            floatVlTotal = 0;
        }
        
        vlTotal.val(urbem.convertFloatToMoney(floatVlTotal));
    }

    $(document).ready(function() {
        codUf.select2('disable');
        fkSwMunicipio.select2('disable');
    });

    codTipoNorma.on('change', function() {
        varJsCodTipoNorma = $(this).val();
    });

    if (urbem.isFunction($.urbemModal)) {
        modal = $.urbemModal();
    }

    codPais.on('change', function() {
        if ($(this).val() == '') {
            return;
        }

        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando estado...')
            .open();
        $.ajax({
            url: "/recursos-humanos/diarias/diaria/" + $(this).val() + "/buscaestado",
            method: "GET",
            data: {
                id: $(this).val()
            },
            dataType: "json",
            success: function (data) {
                urbem.populateSelect(codUf, data, {value: 'codUf', label: 'nomUf'});
                codUf.select2('enable');
                modal.close();
            }
        });
    });

    fkDiariasTipoDiaria.on('change', function () {
        if ($(this).val() == '') {
            return;
        }

        $.ajax({
            url: "/recursos-humanos/diarias/diaria/" + $(this).val() + "/valor-unitario",
            method: "GET",
            data: {
                id: $(this).val()
            },
            dataType: "json",
            success: function (data) {
                vlUnitario.val(data.valorUnitario);
                calculaQuantidadeDiarias(quantidade.val());
            }
        });
    });

    codUf.on('change', function() {
        varJsCodUf = $(this).val();
        fkSwMunicipio.select2('enable');
    });

    quantidade.on('focusout', function () {
        calculaQuantidadeDiarias($(this).val());
    });
})(jQuery, window, UrbemSonata);
