$(function () {
    "use strict";

    var area = UrbemSonata.giveMeBackMyField('area'),
        areaRestante = UrbemSonata.giveMeBackMyField('areaRestante'),
        loteRestante = UrbemSonata.giveMeBackMyField('loteRestante'),
        numLote = UrbemSonata.giveMeBackMyField('numLote'),
        localizacao = UrbemSonata.giveMeBackMyField('fkImobiliarioLocalizacao'),
        submitStatus = true;

    area.on('click', function() {
        $('.sonata-ba-field-error-messages').remove();
    });

    if (numLote.attr('disabled') == undefined) {
        submitStatus = false;
    }

    numLote.on('change', function () {
        if ($(this).val() != '') {
            verificaLoteLocalizacaoValor(localizacao.val(), $(this).val());
        }
    });

    $('form').submit(function() {
        if ((UrbemSonata.convertMoneyToFloat(area.val()) > parseFloat(areaRestante.val())) && (loteRestante.val() > 1)) {
            mensagemErro(area, 'A área informada deve ser menor ou igual a área disponível para validação (' + UrbemSonata.convertFloatToMoney(areaRestante.val()) + ').');
            activeTab(1);
            return false;
        } else if ((UrbemSonata.convertMoneyToFloat(area.val()) != parseFloat(areaRestante.val())) && (loteRestante.val() == 1)) {
            mensagemErro(area, 'A área informada deve ser igual a área disponível para validação (' + UrbemSonata.convertFloatToMoney(areaRestante.val()) + ').');
            activeTab(1);
            return false;
        }
        if ((numLote.attr('disabled') == undefined) && submitStatus == false) {
            mensagemErro(numLote, 'Número do lote já cadastrado nesta localização!');
            activeTab(1);
            return false;
        }
        return submitStatus;
    });

    function activeTab(identificador) {
        $('a[href^="#tab_' + UrbemSonata.uniqId + '"]').parent().removeClass('active');

        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').attr('aria-expanded', true);
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').find('.has-errors').removeClass('hide');
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').parent().addClass('active');

        $('.tab-pane').removeClass('active in');
        $('#tab_' + UrbemSonata.uniqId + '_' + identificador).addClass('active in');
    }

    function mensagemErro(campo, memsagem) {
        $('.sonata-ba-field-error-messages').remove();
        var message = '<div class="help-block sonata-ba-field-error-messages">' +
            '<ul class="list-unstyled">' +
            '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
            '</ul></div>';
        campo.after(message);
    }

    function verificaLoteLocalizacaoValor(codLocalizacao, valor) {
        var numLote = UrbemSonata.giveMeBackMyField('numLote');
        submitStatus = false;
        $('.sonata-ba-field-error-messages').remove();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/lote/consultar-lote-localizacao-valor",
            method: "POST",
            data: {codLocalizacao: codLocalizacao, valor: valor},
            dataType: "json",
            success: function (data) {
                if (data) {
                    var message = '<div class="help-block sonata-ba-field-error-messages">' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-exclamation-circle"></i>  Número do lote já cadastrado nesta localização!</li>' +
                        '</ul></div>';
                    numLote.after(message);
                } else {
                    submitStatus = true;
                }
            }
        });
    }
}());