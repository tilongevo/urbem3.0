$(document).ready(function(){
    'use strict';

    var localizacao = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        lote = $("#" + UrbemSonata.uniqId + "_fkImobiliarioImovel__fkImobiliarioImovelLotes_autocomplete_input"),
        imovel = $("#" + UrbemSonata.uniqId + "_fkImobiliarioImovel_autocomplete_input"),
        imovelContainer = $("#s2id_" + UrbemSonata.uniqId + "_fkImobiliarioImovel_autocomplete_input"),
        cgm = $("#" + UrbemSonata.uniqId + "_cgm_autocomplete_input"),
        cgmContainer = $("#s2id_" + UrbemSonata.uniqId + "_cgm_autocomplete_input"),
        quota = UrbemSonata.giveMeBackMyField('cota'),
        modeloProprietario = $('.row-modelo-proprietario'),
        modeloAdquirente = $('.row-modelo-adquirente'),
        quotaTotal = 0;

    if (quota == undefined) {
        return false;
    }

    lote.select2('disable');

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        if ($(this).val() != '') {
            lote.select2('enable');
        } else {
            lote.select2('val', '');
            lote.select2('disable');
            imovel.select2('val', '');
            limparProprietarios();
        }
        window.varJsCodLocalizacao = $(this).val();
    });

    window.varJsCodLote= lote.val();
    lote.on("change", function() {
        window.varJsCodLote = $(this).val();
    });

    if (imovel.val() != '') {
        carregaProprietarios(imovel.val());
    }

    imovel.on('change', function () {
        if ($(this).val()) {
            carregaProprietarios($(this).val());
            carregaImovelInfo($(this).val());
        } else {
            limparProprietarios();
        }
    });

    function carregaProprietarios(inscricaoMunicipal) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Carregando, por favor aguarde.</h4>');
        limparProprietarios();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/transferencia-propriedade/consulta-proprietarios",
            method: "POST",
            data: {inscricaoMunicipal: inscricaoMunicipal},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    montaLinhaProprietario(value)
                });
                fechaModal();
            }
        });
    }

    function carregaImovelInfo(inscricaoMunicipal) {
        $.ajax({
            url: "/tributario/cadastro-imobiliario/transferencia-propriedade/consulta-imovel",
            method: "POST",
            data: {inscricaoMunicipal: inscricaoMunicipal},
            dataType: "json",
            success: function (data) {
                localizacao.select2('data', {id: data.codLocalizacao, label: data.codigoComposto});
                lote.select2('enable');
                lote.select2('data', {id: data.codLote, label: data.numLote});
            }
        });
    }

    function carregaAdquirente(numcgm) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Carregando, por favor aguarde.</h4>');
        $.ajax({
            url: "/tributario/cadastro-imobiliario/transferencia-propriedade/consulta-adquirente",
            method: "POST",
            data: {numcgm: numcgm},
            dataType: "json",
            success: function (data) {
                montaLinhaAdquirente(data);
                fechaModal();
            }
        });
    }

    function montaLinhaProprietario(proprietario) {
        var row = modeloProprietario.clone();
        row.removeClass('row-modelo-proprietario');
        row.addClass('row-proprietario');
        row.attr('id', 'proprietario-' + proprietario.numcgm);
        row.find('.cgm').append(proprietario.numcgm);
        row.find('.nome').html(proprietario.nomCgm);
        row.find('.quota').html(proprietario.cota);
        row.find('.imput-proprietario').attr('value', proprietario.numcgm);
        row.find('.imput-proprietario-quota').attr('value', proprietario.cota);
        row.show();

        $('.empty-row-proprietarios').hide();
        $('#tableProprietariosManuais').append(row);
    }

    $("#manuais").on("click", function() {
        if (!imovel.val()) {
            UrbemSonata.setFieldErrorMessage('imovel', 'Preencha este campo.', imovelContainer);
            return false;
        }
        if (cgm.val() == '') {
            UrbemSonata.setFieldErrorMessage('cgm', 'Preencha este campo.', cgmContainer);
            return false;
        }
        if (quota.val() == '') {
            UrbemSonata.setFieldErrorMessage('cota', 'Preencha este campo.', quota.parent().parent());
            return false;
        }
        if ($('#adquirente-' + cgm.val()).length >= 1) {
            UrbemSonata.setFieldErrorMessage('cgm', 'CGM já informado!', cgmContainer);
            return false;
        }
        if (quotaTotal == 100) {
            UrbemSonata.setFieldErrorMessage('cota', 'A soma das quotas já é igual a 100%!', quota.parent().parent());
            return false;
        } else if (parseInt(quota.val()) > (100 - quotaTotal)) {
            UrbemSonata.setFieldErrorMessage('cota', 'Quota deve ter valor menor ou igual a ' + (100 - quotaTotal) + '!', quota.parent().parent());
            return false;
        }
        carregaAdquirente(cgm.val());
    });

    function montaLinhaAdquirente(adquirente) {
        quotaTotal += parseInt(quota.val());
        var row = modeloAdquirente.clone();
        row.removeClass('row-modelo-adquirente');
        row.addClass('row-adquirente');
        row.attr('id', 'adquirente-' + adquirente.numcgm);
        row.find('.cgm').append(adquirente.numcgm);
        row.find('.nome').html(adquirente.nomCgm);
        row.find('.quota-atual').html($('#proprietario-' + adquirente.numcgm).find('.imput-proprietario-quota').val());
        row.find('.quota-futura').html(quota.val() + '.00');
        row.find('.imput-adquirente').attr('value', adquirente.numcgm);
        row.find('.imput-adquirente-quota').attr('value', quota.val());
        row.show();

        $('.empty-row-adquirentes').hide();
        $('#tableAdquirentesManuais').append(row);

        cgm.select2('val', '');
        quota.val('');
    }

    function limparProprietarios() {
        $('.row-proprietario').each(function () {
            $(this).remove();
        });
        $('.empty-row-proprietarios').show();
    }

    if ($(".row-adquirente").length > 0) {
        $('.empty-row-adquirentes').hide();
        $('.imput-adquirente-quota').each(function(){
            if ($(this).val() != '') {
                quotaTotal += parseInt($(this).val());
            }
        })
    }

    quota.mask('000');

    $(document).on('click', '.remove', function () {
        quotaTotal -= parseInt($(this).parent().find('.imput-adquirente-quota').attr('value'));
        $(this).parent().remove();
        if ($(".row-adquirente").length <= 0) {
            $('.empty-row-adquirentes').show();
        }
    });

    $(document).ready(function() {
        cgmContainer.mouseover(function() {
            $(this).find('.sonata-ba-field-error-messages').remove();
            $(this).parent().removeClass('has-error');
        });
        imovelContainer.mouseover(function() {
            $(this).find('.sonata-ba-field-error-messages').remove();
            $(this).parent().removeClass('has-error');
        });
        quota.parent().parent().mouseover(function() {
            $(this).find('.sonata-ba-field-error-messages').remove();
            $(this).parent().removeClass('has-error');
        });
    });

    $('form').submit(function() {
        if ($(".row-adquirente").length <= 0) {
            UrbemSonata.setFieldErrorMessage('cgm', 'Deve ser informado ao menos um adquirente!', cgmContainer);
            return false;
        }
        if (($(".row-adquirente").length > 0) && (quotaTotal < 100)) {
            UrbemSonata.setFieldErrorMessage('cgm', 'A soma das quotas dos adquirentes deve ser igual a 100%!', cgmContainer);
            return false;
        }
        return true;
    });
}());
