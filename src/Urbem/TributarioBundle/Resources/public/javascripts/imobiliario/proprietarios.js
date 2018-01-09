$(function () {
    "use strict";

    var cgm = $("#" + UrbemSonata.uniqId + "_proprietario_numcgm_autocomplete_input"),
        quota = UrbemSonata.giveMeBackMyField('proprietario_quota'),
        quotaContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_proprietario_quota'),
        cgmContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_proprietario_numcgm'),
        promitente = UrbemSonata.giveMeBackMyField('proprietario_promitente'),
        modeloProprietario = $('.row-modelo-proprietarios'),
        modeloPromitente = $('.row-modelo-proprietarios-promitente'),
        quotaTotal = 0,
        quotaPromitente = 0;

    if (quota == undefined) {
        return false;
    }
    quota.mask('000');

    $("#manuais").on("click", function() {
        if ($('#proprietario-' + cgm.val()).length >= 1) {
            mensagemErro(cgmContainer, 'CGM já informado!');
            return false;
        }

        if ((quotaTotal == 100) && (promitente.val() == 0)) {
            mensagemErro(quotaContainer, 'A soma das quotas já é igual a 100%!');
            return false;
        } else if ((parseInt(quota.val()) > (100 - quotaTotal)) && ((promitente.val() == 0))) {
            mensagemErro(quota, 'Quota deve ter valor menor ou igual a ' + (100 - quotaTotal) + '!');
            return false;
        }

        if ((quotaPromitente == 100) && (promitente.val() == 1)) {
            mensagemErro(quotaContainer, 'A soma das quotas já é igual a 100%!');
            return false;
        } else if ((parseInt(quota.val()) > (100 - quotaPromitente)) && ((promitente.val() == 1))) {
            mensagemErro(quotaContainer, 'Quota deve ter valor menor ou igual a ' + (100 - quotaPromitente) + '!');
              false;
        }
        novaLinha(promitente.val());
    });


    function novaLinha(situacao)
    {
        $('.sonata-ba-field-error-messages').remove();

        var nome = cgm.select2('data').label;
        if (nome != undefined) {
            nome = nome.split(' - ');
            nome = nome[1];
        }

        if (situacao == 0) {
            quotaTotal += parseInt(quota.val());
            var row = modeloProprietario.clone();
            row.removeClass('row-modelo-proprietarios');
            row.addClass('row-proprietarios');
            row.attr('id', 'proprietario-' + cgm.val());
            row.find('.cgm').append(cgm.val());
            row.find('.nome').html(nome);
            row.find('.quota').html(quota.val() + '%');
            row.find('.imput-proprietario').attr('value', cgm.val());
            row.find('.imput-proprietario-quota').attr('value', quota.val());
            row.show();

            $('.empty-row-proprietarios').hide();
            $('#tableProprietariosManuais').append(row);
        } else {
            quotaPromitente += parseInt(quota.val());
            var row = modeloPromitente.clone();
            row.removeClass('row-modelo-proprietarios-promitente');
            row.addClass('row-proprietarios-promitente');
            row.attr('id', 'proprietario-' + cgm.val());
            row.find('.cgm').append(cgm.val());
            row.find('.nome').html(nome);
            row.find('.quota').html(quota.val()  + '%');
            row.find('.imput-promitente').attr('value', cgm.val());
            row.find('.imput-promitente-quota').attr('value', quota.val());
            row.show();

            $('.empty-row-proprietarios-promitente').hide();
            $('#tableProprietariosPromitenteManuais').append(row);
        }
        cgm.select2('val', '');
    }

    quota.on('click', function () {
        $('.sonata-ba-field-error-messages').remove();
    });

    cgm.on('click', function () {
        $('.sonata-ba-field-error-messages').remove();
    });

    if ($(".row-proprietarios").length > 0) {
        $('.empty-row-proprietarios').hide();
        $('.imput-proprietario-quota').each(function(){
            if ($(this).val() != '') {
                quotaTotal += parseInt($(this).val());
            }
        })
    }

    if ($(".row-proprietarios-promitente").length > 0) {
        $('.empty-row-proprietarios-promitente').hide();
        $('.imput-promitente-quota').each(function(){
            if ($(this).val() != '') {
                quotaPromitente += parseInt($(this).val());
            }
        })
    }

    $('form').submit(function() {
        if ($(".row-proprietarios").length <= 0) {
            mensagemErro(cgmContainer, 'Deve ser informado ao menos um proprietário!');
            activeTab(2);
            return false;
        }
        if (($(".row-proprietarios").length > 0) && (quotaTotal < 100)) {
            mensagemErro(quotaContainer, 'A soma das quotas dos proprietários deve ser igual a 100%!');
            activeTab(2);
            return false;
        }
        if (($(".row-proprietarios-promitente").length > 0) && (quotaPromitente < 100)) {
            mensagemErro(quotaContainer, 'A soma das quotas dos proprietários promitentes deve ser igual a 100%!');
            activeTab(2);
            return false;
        }
        return true;
    });

    $(document).on('click', '.remove', function () {
        if ($(this).parent().hasClass('row-proprietarios')) {
            quotaTotal -= parseInt($(this).parent().find('.imput-proprietario-quota').attr('value'));
        } else {
            quotaPromitente -= parseInt($(this).parent().find('.imput-promitente-quota').attr('value'));
        }
        $(this).parent().remove();
        if ($(".row-proprietarios").length <= 0) {
            $('.empty-row-proprietarios').show();
        }
        if ($(".row-proprietarios-promitente").length <= 0) {
            $('.empty-row-proprietarios-promitente').show();
        }
    });

    function mensagemErro(campo, memsagem) {
        var message = '<div class="help-block sonata-ba-field-error-messages">' +
            '<ul class="list-unstyled">' +
            '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
            '</ul></div>';
        campo.after(message);
    }

    function activeTab(identificador) {
        $('a[href^="#tab_' + UrbemSonata.uniqId + '"]').parent().removeClass('active');

        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').attr('aria-expanded', true);
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').find('.has-errors').removeClass('hide');
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').parent().addClass('active');

        $('.tab-pane').removeClass('active in');
        $('#tab_' + UrbemSonata.uniqId + '_' + identificador).addClass('active in');
    }
}());