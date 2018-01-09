$(document).ready(function() {
    'use strict';

    $("input[name='dtAnulacao']").datetimepicker({"pickTime":false,"useCurrent":true,"minDate":"1\/1\/1900","maxDate":null,"showToday":true,"language":"pt_BR","disabledDates":[],"enabledDates":[],"icons":{"time":"fa fa-clock-o","date":"fa fa-calendar","up":"fa fa-chevron-up","down":"fa fa-chevron-down"},"useStrict":false,"sideBySide":false,"daysOfWeekDisabled":[],"collapse":true,"calendarWeeks":false,"viewMode":"days","defaultDate":"27\/07\/2017","useSeconds":false});

    calculaCampos();
    function calculaCampos()
    {
        var totalLiquidar = 0.00;
        var saldoLiquidar = 0.00;
        var totalEmpenho = $('#' + UrbemSonata.uniqId + '_totalEmpenho').val();
        totalEmpenho = parseFloat(totalEmpenho.replace('.','').replace(',','.'));
        for (var i = 1; i <= $('.input-rh-table-liquidar').length; i++) {
            var item = $('input[name="itensEmpenho[' + i + ']"]').val();
            if (item != "" && item != null) {
                totalLiquidar += parseFloat(item.replace(',',''));
            } else {
                totalLiquidar += 0.00;
            }
        }
        saldoLiquidar =  parseFloat(totalEmpenho) - totalLiquidar;
        $('#' + UrbemSonata.uniqId + '_totalLiquidar').val(totalLiquidar.toFixed(2).replace('.',','));
        $('#' + UrbemSonata.uniqId + '_saldoLiquidar').val(saldoLiquidar.toFixed(2).replace('.',','));

        $('#' + UrbemSonata.uniqId + '_totalEmpenho').mask('###0,00', {reverse: true});
        $('#' + UrbemSonata.uniqId + '_totalLiquidar').mask('###0,00', {reverse: true});
        $('#' + UrbemSonata.uniqId + '_saldoLiquidar').mask('#.##0,00', {reverse: true});
    }

    $('.input-rh-table-liquidar').on('change', function(){
        calculaCampos();
    });

    var tipo = $('input[name="' + UrbemSonata.uniqId + '[incluirDocumentoFiscal]"]');
    tipo.on('ifChecked', function() {
        var isChecked = $('#' + UrbemSonata.uniqId + '_incluirDocumentoFiscal_0').is(':checked');
        if(isChecked) {
            UrbemSonata.sonataFieldContainerShow('_inscricaoMunicipal');
        } else {
            UrbemSonata.sonataFieldContainerHide('_inscricaoMunicipal');
        }
    });

    if ( $('#' + UrbemSonata.uniqId + '_incluirDocumentoFiscal_1').is(':checked') ) {
        UrbemSonata.sonataFieldContainerHide('_inscricaoMunicipal');
    }

    $('#'+ UrbemSonata.uniqId + '_assinaturas').on('change', function(){
        var modal = new UrbemModal();
        modal.disableBackdrop();
        modal.setTitle('Liquidar empenho');
        modal.setContent('Aguarde...');
        modal.open();

        var assinaturas = $('#'+ UrbemSonata.uniqId + '_assinaturas').val();

        $.ajax({
            url: "/financeiro/empenho/liquidar-empenho/assinatura",
            method: "POST",
            data: {
                assinaturas: assinaturas
            },
            dataType: "json",
            success: function () {
                modal.close();
            },
            fail: function() {
                var modalErro = new UrbemModal();
                modalErro.setTitle('Erro ao carregar conteúdo');
                modalErro.setContent('Houve um erro na aplicação, por favor contate o suporte técnico');
                modalErro.open();
            }
        });
    });
}());
