(function ($, urbem) {
    'use strict';

    var faltas = urbem.giveMeBackMyField('faltas'),
        ano = urbem.giveMeBackMyField('ano'),
        mes = urbem.giveMeBackMyField('mes'),
        codForma = urbem.giveMeBackMyField('codForma'),
        diasFerias = urbem.giveMeBackMyField('diasFerias'),
        diasAbono = urbem.giveMeBackMyField('diasAbono'),
        dtInicial = urbem.giveMeBackMyField('dtInicial'),
        dtFinal = urbem.giveMeBackMyField('dtFinal'),
        dtInicialFerias = urbem.giveMeBackMyField('dtInicialFerias'),
        dtTerminoFerias = urbem.giveMeBackMyField('dtTerminoFerias'),
        dtRetornoFerias = urbem.giveMeBackMyField('dtRetornoFerias')
    ;

    function showHideFeriasFields(codForma) {
        if (codForma != '') {
            urbem.sonataFieldContainerShow('_dtInicialFerias', true);
            urbem.sonataFieldContainerShow('_dtTerminoFerias', true);
            urbem.sonataFieldContainerShow('_dtRetornoFerias', true);
            urbem.sonataFieldContainerShow('_ano', true);
            urbem.sonataFieldContainerShow('_mes', true);
            urbem.sonataFieldContainerShow('_codTipo', true);
            urbem.sonataFieldContainerShow('_pagar13');
        } else {
            urbem.sonataFieldContainerHide('_dtInicialFerias');
            urbem.sonataFieldContainerHide('_dtTerminoFerias');
            urbem.sonataFieldContainerHide('_dtRetornoFerias');
            urbem.sonataFieldContainerHide('_ano');
            urbem.sonataFieldContainerHide('_mes');
            urbem.sonataFieldContainerHide('_codTipo');
            urbem.sonataFieldContainerHide('_pagar13');
        }
    }

    showHideFeriasFields(codForma.val());

    ano.on('change', function() {
        if ($(this).val() != '') {
            abreModal('Carregando','Aguarde, buscando compentencias...');
            $.ajax({
                url: '/api-search-competencia-pagamento/preencher-competencia',
                method: "POST",
                data: {
                    ano: $(this).val()
                },
                dataType: "json",
                success: function (data) {
                    urbem.populateSelect(mes, data, {value: 'id', label: 'label'}, mes.data('mes'));
                    fechaModal();
                }
            });
        }
    });

    codForma.on('change', function() {
        diasFerias.val($(this).find(':selected').data('dias'));
        diasAbono.val($(this).find(':selected').data('abono'));

        showHideFeriasFields($(this).val());

        $.ajax({
            url: '/recursos-humanos/pessoal/ferias/conceder/preencher-quant-dias-gozo/',
            method: 'POST',
            data: {
                inCodFormaPagamento: $(this).val(),
                inQuantFaltas: faltas.val(),
                dtInicial: dtInicial.val(),
                dtFinal: dtFinal.val(),
            },
            dataType: "json",
            sucess: function (data) {
            }
        });
    });

    dtInicialFerias.on('blur', function () {
        calcDatasFerias($(this));
    });

    $("#dp_" + urbem.uniqId + "_dtInicialFerias").on('dp.change changeDate', function () {
        calcDatasFerias(dtInicialFerias);
    });

    $("form[role='form']").on("submit", function() {
        return true;
    });

})(jQuery, UrbemSonata);
