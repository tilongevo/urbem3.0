$(function () {
    "use strict";

    var lancamentoManualCredito = $('#' + UrbemSonata.uniqId + '_lancamentoManualDe_0'),
        lancamentoManualGrupoCredito = $('#' + UrbemSonata.uniqId + '_lancamentoManualDe_1'),
        valor = $('#' + UrbemSonata.uniqId + '_valor'),
        valorTotal = $('#' + UrbemSonata.uniqId + '_valorTotal'),
        exercicio = $('#' + UrbemSonata.uniqId + '_exercicio'),
        credito = $('#' + UrbemSonata.uniqId + '_fkMonetarioCredito'),
        grupoCredito = $('#' + UrbemSonata.uniqId + '_fkArrecadacaoGrupoCredito'),
        contribuinte = $('#' + UrbemSonata.uniqId + '_fkSwCgm_autocomplete_input'),
        inscricaoImobiliaria = $('#' + UrbemSonata.uniqId + '_fkImobiliarioImovel_autocomplete_input'),
        inscricaoEconomica = $('#' + UrbemSonata.uniqId + '_fkEconomicoCadastroEconomico_autocomplete_input'),
        filtrarCGM = $('#' + UrbemSonata.uniqId + '_filtrarPor_0'),
        filtrarInscricaoImobiliaria = $('#' + UrbemSonata.uniqId + '_filtrarPor_1'),
        filtrarInscricaoEconomica = $('#' + UrbemSonata.uniqId + '_filtrarPor_2'),
        emissaoNaoEmitir = $('#' + UrbemSonata.uniqId + '_emissaoCarnes_0'),
        emissaoImpressaoLocal = $('#' + UrbemSonata.uniqId + '_emissaoCarnes_1'),
        modelo = UrbemSonata.giveMeBackMyField('modelo'),
        modeloCredito = $('.row-modelo-credito');

    $('.row-modelo-credito').remove();

    grupoCredito.parent().parent().addClass('hide');
    grupoCredito.attr('disabled', true);
    valorTotal.parent().parent().parent().addClass('hide');
    lancamentoManualCredito.on('ifChecked', function(){
        grupoCredito.parent().parent().addClass('hide');
        grupoCredito.attr('disabled', true);
        valorTotal.parent().parent().parent().addClass('hide');
        valor.parent().parent().parent().removeClass('hide');
        valor.attr('disabled', false);
        credito.parent().parent().removeClass('hide');
        credito.attr('disabled', false);
        exercicio.parent().parent().removeClass('hide');
        exercicio.attr('disabled', false);
    });

    lancamentoManualGrupoCredito.on('ifChecked', function(){
        credito.parent().parent().addClass('hide');
        credito.attr('disabled', true);
        exercicio.parent().parent().addClass('hide');
        exercicio.attr('disabled', true);
        grupoCredito.parent().parent().removeClass('hide');
        grupoCredito.attr('disabled', false);
        valor.parent().parent().parent().addClass('hide');
        valor.attr('disabled', true);
        valorTotal.parent().parent().parent().removeClass('hide');
    });

    inscricaoImobiliaria.parent().parent().addClass('hide');
    inscricaoEconomica.parent().parent().addClass('hide');
    inscricaoImobiliaria.select2('disable');
    inscricaoEconomica.select2('disable');

    filtrarCGM.on('ifChecked', function(){
        contribuinte.parent().parent().removeClass('hide');
        inscricaoImobiliaria.parent().parent().addClass('hide');
        inscricaoEconomica.parent().parent().addClass('hide');
        inscricaoImobiliaria.select2('val', '');
        inscricaoEconomica.select2('val', '');
        contribuinte.select2('enable');
        inscricaoImobiliaria.select2('disable');
        inscricaoEconomica.select2('disable');
    });

    filtrarInscricaoImobiliaria.on('ifChecked', function(){
        contribuinte.parent().parent().addClass('hide');
        inscricaoImobiliaria.parent().parent().removeClass('hide');
        inscricaoEconomica.parent().parent().addClass('hide');
        contribuinte.select2('val', '');
        inscricaoEconomica.select2('val', '');
        contribuinte.select2('disable');
        inscricaoImobiliaria.select2('enable');
        inscricaoEconomica.select2('disable');
    });

    filtrarInscricaoEconomica.on('ifChecked', function(){
        contribuinte.parent().parent().addClass('hide');
        inscricaoImobiliaria.parent().parent().addClass('hide');
        inscricaoEconomica.parent().parent().removeClass('hide');
        contribuinte.select2('val', '');
        inscricaoImobiliaria.select2('val', '');
        contribuinte.select2('disable');
        inscricaoImobiliaria.select2('disable');
        inscricaoEconomica.select2('enable');
    });

    modelo.parent().parent().addClass('hide');
    modelo.attr('disabled', true);
    emissaoNaoEmitir.on('ifChecked', function(){
        modelo.parent().parent().addClass('hide');
        modelo.attr('disabled', true);
    });
    emissaoImpressaoLocal.on('ifChecked', function(){
        modelo.parent().parent().removeClass('hide');
        modelo.attr('disabled', false);
    });

    valor.on('mouseover', function () {
        valor.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    valorTotal.on('mouseover', function () {
        valorTotal.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    grupoCredito.on('change', function () {
        if ($(this).val() != '') {
            carregaCreditos($(this).val());
        } else {
            clearListaCreditos();
        }
    });

    inscricaoImobiliaria.on('change', function () {
        consultaImovel($(this).val());
    });

    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioImovel').on('mouseover', function () {
        inscricaoImobiliaria.parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    function consultaImovel(inscricaoMunicipal) {
        $.ajax({
            url: "/tributario/arrecadacao/calculo/efetuar-lancamento/manual/consultar-imovel",
            method: "POST",
            data: {inscricaoMunicipal: inscricaoMunicipal},
            dataType: "json",
            success: function (data) {
                if (!data.length) {
                    inscricaoImobiliaria.select2('val', '');
                    UrbemSonata.setFieldErrorMessage('inscricaoImobiliaria', 'Código de inscrição imobiliária inválido. (' + inscricaoMunicipal + ')', inscricaoImobiliaria.parent());
                    return false;
                }
            }
        });
    }

    function carregaCreditos(codGrupoCredito) {
        clearListaCreditos();
        abreModal('Carregando','Aguarde, carregando lista de créditos');
        $.ajax({
            url: "/tributario/arrecadacao/calculo/efetuar-lancamento/manual/consultar-creditos",
            method: "POST",
            data: {codGrupoCredito: codGrupoCredito},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    var row = modeloCredito.clone();
                    row.removeClass('row-modelo-credito');
                    row.addClass('row-credito');
                    row.attr('id', 'credito-' + value.cod_credito);
                    row.find('.input-credito').attr('value', value.cod_credito + '~' + value.cod_genero + '~' + value.cod_especie + '~' + value.cod_natureza);
                    row.find('.codigo').append(value.cod_credito + '.' + value.cod_genero + '.' + value.cod_especie + '.' + value.cod_natureza);
                    row.find('.descricao').html(value.descricao_credito);
                    row.find('.valor-credito').mask("#.##0,00", {reverse: true});
                    (function () {
                        var valorAnterior;
                        row.find('.valor-credito').on('focus', function () {
                            valorAnterior = UrbemSonata.convertMoneyToFloat(this.value);
                        }).change(function() {
                            valorTotal.val(UrbemSonata.convertFloatToMoney((UrbemSonata.convertMoneyToFloat(valorTotal.val()) - valorAnterior) + UrbemSonata.convertMoneyToFloat(this.value)));
                            valorAnterior = UrbemSonata.convertMoneyToFloat(this.value);
                        });
                    })();
                    row.show();

                    $('#tableCreditosManuais').append(row);
                });
                $('.creditos').show();
                fechaModal();
            }
        });
    }

    function clearListaCreditos() {
        $('#tableCreditosManuais').empty();
        $('.creditos').hide();

    }

    $('form').submit(function() {
        if ((lancamentoManualCredito.is(':checked')) && (UrbemSonata.convertMoneyToFloat(valor.val()) <= 0)) {
            UrbemSonata.setFieldErrorMessage('valor', 'O valor deve ser maior que zero.', valor.parent().parent());
            window.scrollTo(0, valor.offsetTop);
            return false;
        }
        if ((lancamentoManualGrupoCredito.is(':checked')) && (UrbemSonata.convertMoneyToFloat(valorTotal.val()) <= 0)) {
            UrbemSonata.setFieldErrorMessage('valorTotal', 'O valor total deve ser maior que zero.', valorTotal.parent().parent());
            window.scrollTo(0, valor.offsetTop);
            return false;
        }
        return true;
    });
}());