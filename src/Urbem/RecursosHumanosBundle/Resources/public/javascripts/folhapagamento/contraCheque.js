(function () {
    'use strict';

    var ano = UrbemSonata.giveMeBackMyField('ano'),
        mes = UrbemSonata.giveMeBackMyField('mes'),
        configuracao = UrbemSonata.giveMeBackMyField('stConfiguracao'),
        inCodComplementar = UrbemSonata.giveMeBackMyField('inCodComplementar'),
        stDesdobramento = UrbemSonata.giveMeBackMyField('stDesdobramento'),
        tipo = UrbemSonata.giveMeBackMyField('tipo'),
        cgmmatricula = UrbemSonata.giveMeBackMyField('codContrato'),
        lotacao = UrbemSonata.giveMeBackMyField('lotacao'),
        local = UrbemSonata.giveMeBackMyField('local');

    ano.on('change', function () {
        if ($(this).val() != '') {
            abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, buscando competências...</h4>');
            $.ajax({
                url: '/api-search-competencia-pagamento/preencher-competencia-folha-pagamento',
                method: "POST",
                data: {
                    ano: $(this).val()
                },
                dataType: "json",
                success: function (data) {
                    UrbemSonata.populateSelect(mes, data, {value: 'id', label: 'label'}, mes.data('mes'));
                    fechaModal();
                }
            });
        }
    });

    cgmmatricula.select2('disable');
    lotacao.prop('disabled', true);
    local.prop('disabled', true);

    tipo.on('change', function(){
        if ($(this).val() == 'cgm_contrato') {
            cgmmatricula.select2('enable');

            lotacao.select2('disable');
            lotacao.select2('data', null);

            local.select2('disable');
            local.select2('data', null);
        } else if ($(this).val() == 'lotacao' ) {
            cgmmatricula.select2('disable');
            cgmmatricula.select2('data', null);

            lotacao.select2('enable');

            local.select2('disable');
            local.select2('data', null);
        } else if ($(this).val() == 'local') {
            cgmmatricula.select2('disable');
            cgmmatricula.select2('data', null);

            lotacao.select2("disable");
            lotacao.select2('data', null);

            local.select2('enable');
        } else {
            cgmmatricula.select2('disable');
            cgmmatricula.select2('data', null);

            lotacao.select2("disable");
            lotacao.select2('data', null);

            local.select2('disable');
            local.select('data', null);
        }
    });

    function carregaComplementar(ano, mes) {
        if (ano != '' && mes != '') {

            abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, buscando folhas complementares...</h4>');
            $.ajax({
                url: '/recursos-humanos/folha-pagamento/relatorios/contra-cheque/consulta-folha-complementar',
                method: "POST",
                data: {
                    ano: ano,
                    mes: mes
                },
                dataType: "json",
                success: function (data) {
                    UrbemSonata.populateSelect(inCodComplementar, data, {
                        value: 'id',
                        label: 'label'
                    }, inCodComplementar.data('id'));
                    fechaModal();
                }
            });
        }
    }

    configuracao.on('change', function () {
        if ($(this).val() != "") {
            if ($(this).val() == '0') {
                inCodComplementar.prop('disabled', false);
                stDesdobramento.prop('disabled', true);
                carregaComplementar(ano.val(), mes.val());
            } else if ($(this).val() == '3') {
                stDesdobramento.prop('disabled', false);
                inCodComplementar.prop('disabled', true);
            } else {
                inCodComplementar.prop('disabled', true);
                stDesdobramento.prop('disabled', true);
            }
        }
    });

}());
